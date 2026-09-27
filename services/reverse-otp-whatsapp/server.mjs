import crypto from 'node:crypto';
import http from 'node:http';
import fs from 'node:fs/promises';
import makeWASocket, { DisconnectReason, useMultiFileAuthState } from '@whiskeysockets/baileys';
import { Boom } from '@hapi/boom';
import pino from 'pino';
import QRCode from 'qrcode';

const required = ['REVERSE_OTP_LISTENER_SECRET', 'REVERSE_OTP_APP_URL', 'REVERSE_OTP_APP_HOST'];
for (const name of required) if (!process.env[name]) throw new Error(`${name} is required`);
const authDir = process.env.REVERSE_OTP_AUTH_DIR || '/var/lib/nawader-reverse-otp-whatsapp';
const secret = process.env.REVERSE_OTP_LISTENER_SECRET;
const endpoint = new URL('/api/internal/reverse-otp/whatsapp', process.env.REVERSE_OTP_APP_URL);
let qrDataUrl = null; let connection = 'starting'; let socket;
const logger = pino({ level: 'silent' });

const textOf = (message = {}) => message.conversation || message.extendedTextMessage?.text || message.imageMessage?.caption || '';
const phoneFromJid = (jid = '') => { const raw = jid.split('@')[0].split(':')[0]; return /^[1-9]\d{7,14}$/.test(raw) ? `+${raw}` : null; };
const tokenFrom = (text) => text.toUpperCase().match(/\b(?:AUTH\s+)?(NAWADER-[A-Z0-9]{10})\b/)?.[1] || null;

async function postInbound({ token, phone, messageId }) {
  const body = JSON.stringify({ token, phone }); const timestamp = String(Math.floor(Date.now() / 1000));
  const signature = crypto.createHmac('sha256', secret).update(`${timestamp}.${messageId}.${body}`).digest('hex');
  const response = await fetch(endpoint, { method: 'POST', body, headers: { Host: process.env.REVERSE_OTP_APP_HOST, 'Content-Type': 'application/json', 'X-Reverse-Otp-Timestamp': timestamp, 'X-Reverse-Otp-Message-Id': messageId, 'X-Reverse-Otp-Signature': signature } });
  return response.ok && (await response.json()).verified === true;
}

async function connect() {
  await fs.mkdir(authDir, { recursive: true, mode: 0o700 });
  const { state, saveCreds } = await useMultiFileAuthState(authDir);
  socket = makeWASocket({ auth: state, logger, markOnlineOnConnect: false, syncFullHistory: false });
  socket.ev.on('creds.update', saveCreds);
  socket.ev.on('connection.update', async ({ connection: next, lastDisconnect, qr }) => {
    if (qr) qrDataUrl = await QRCode.toDataURL(qr, { margin: 1, width: 280 });
    if (next) connection = next;
    if (next === 'open') qrDataUrl = null;
    if (next === 'close') { const code = new Boom(lastDisconnect?.error)?.output?.statusCode; if (code !== DisconnectReason.loggedOut) setTimeout(connect, 3000); }
  });
  socket.ev.on('messages.upsert', async ({ type, messages }) => {
    if (type !== 'notify') return;
    for (const message of messages) {
      if (message.key.fromMe || message.key.remoteJid?.endsWith('@g.us')) continue;
      const token = tokenFrom(textOf(message.message)); const phone = phoneFromJid(message.key.remoteJid); const messageId = message.key.id;
      if (!token || !phone || !messageId) continue;
      try { if (await postInbound({ token, phone, messageId })) await socket.sendMessage(message.key.remoteJid, { text: '✅ تم التحقق بنجاح. يمكنك العودة إلى المنصة.' }); } catch (error) { console.error('reverse-otp inbound rejected', error.message); }
    }
  });
}

http.createServer((request, response) => {
  if (request.headers.authorization !== `Bearer ${secret}`) { response.writeHead(401); return response.end(); }
  if (request.url !== '/status') { response.writeHead(404); return response.end(); }
  response.setHeader('Content-Type', 'application/json'); response.end(JSON.stringify({ status: connection, qr: qrDataUrl }));
}).listen(3871, '127.0.0.1');

connect().catch((error) => { console.error(error); process.exit(1); });
