/**
 * NAWADER — نوادر
 * World-Class Strategic Platform
 * Cinematic 3D Space Experience
 */

import './bootstrap';

// ═══════════════════════════════════════════════
// THREE.JS SPACE CANVAS
// ═══════════════════════════════════════════════
class NawaderSpaceCanvas {
  constructor() {
    this.canvas = document.getElementById('nw-canvas');
    if (!this.canvas) return;

    this.scene = null;
    this.camera = null;
    this.renderer = null;
    this.particles = null;
    this.nebula = [];
    this.grid = null;
    this.animFrame = null;
    this.mouse = { x: 0, y: 0 };
    this.time = 0;

    this.init();
    this.animate();
    this.bindEvents();
  }

  async init() {
    // Dynamically load Three.js
    if (typeof THREE === 'undefined') {
      await this.loadScript('https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js');
    }

    const W = window.innerWidth;
    const H = window.innerHeight;

    // Scene
    this.scene = new THREE.Scene();
    this.scene.fog = new THREE.FogExp2(0x020408, 0.035);

    // Camera
    this.camera = new THREE.PerspectiveCamera(60, W / H, 0.1, 2000);
    this.camera.position.set(0, 0, 30);

    // Renderer
    this.renderer = new THREE.WebGLRenderer({
      canvas: this.canvas,
      antialias: true,
      alpha: true,
    });
    this.renderer.setSize(W, H);
    this.renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
    this.renderer.setClearColor(0x020408, 1);
    this.renderer.toneMapping = THREE.ACESFilmicToneMapping;
    this.renderer.toneMappingExposure = 0.8;

    this.createStarfield();
    this.createNebulaClouds();
    this.createGridFloor();
    this.createGlowOrbs();
    this.createConstellations();
    this.createHologramPyramid();
    this.setLandscape(localStorage.getItem('nw_landscape') || 'alula');
  }

  loadScript(src) {
    return new Promise((resolve) => {
      const s = document.createElement('script');
      s.src = src;
      s.onload = resolve;
      document.head.appendChild(s);
    });
  }

  createStarfield() {
    const count = 8000;
    const geo = new THREE.BufferGeometry();
    const pos = new Float32Array(count * 3);
    const colors = new Float32Array(count * 3);
    const sizes = new Float32Array(count);

    const starColors = [
      new THREE.Color(0xffffff),
      new THREE.Color(0xD4A843), // gold
      new THREE.Color(0x00D4C8), // teal
      new THREE.Color(0x7B5CE4), // purple
      new THREE.Color(0xffffff),
      new THREE.Color(0xffffff),
    ];

    for (let i = 0; i < count; i++) {
      pos[i * 3]     = (Math.random() - 0.5) * 2000;
      pos[i * 3 + 1] = (Math.random() - 0.5) * 2000;
      pos[i * 3 + 2] = (Math.random() - 0.5) * 2000;

      const c = starColors[Math.floor(Math.random() * starColors.length)];
      colors[i * 3]     = c.r;
      colors[i * 3 + 1] = c.g;
      colors[i * 3 + 2] = c.b;

      sizes[i] = Math.random() * 3 + 0.5;
    }

    geo.setAttribute('position', new THREE.BufferAttribute(pos, 3));
    geo.setAttribute('color', new THREE.BufferAttribute(colors, 3));
    geo.setAttribute('size', new THREE.BufferAttribute(sizes, 1));

    const mat = new THREE.ShaderMaterial({
      uniforms: {
        time: { value: 0 },
        pixelRatio: { value: Math.min(window.devicePixelRatio, 2) },
      },
      vertexShader: `
        attribute float size;
        attribute vec3 color;
        varying vec3 vColor;
        uniform float time;
        void main() {
          vColor = color;
          vec4 mvPos = modelViewMatrix * vec4(position, 1.0);
          float twinkle = sin(time * 2.0 + position.x * 0.01 + position.y * 0.01) * 0.5 + 0.5;
          gl_PointSize = size * (1.0 + twinkle * 0.4) * (300.0 / -mvPos.z);
          gl_Position = projectionMatrix * mvPos;
        }
      `,
      fragmentShader: `
        varying vec3 vColor;
        void main() {
          float d = length(gl_PointCoord - 0.5);
          if (d > 0.5) discard;
          float alpha = 1.0 - smoothstep(0.2, 0.5, d);
          gl_FragColor = vec4(vColor, alpha * 0.9);
        }
      `,
      transparent: true,
      vertexColors: true,
      depthWrite: false,
      blending: THREE.AdditiveBlending,
    });

    this.particles = new THREE.Points(geo, mat);
    this.scene.add(this.particles);
  }

  createNebulaClouds() {
    const nebulaData = [
      { color: 0xD4A843, pos: [-40, 15, -80], size: 60 },
      { color: 0x00D4C8, pos: [50, -20, -100], size: 80 },
      { color: 0x7B5CE4, pos: [0, 30, -120], size: 70 },
      { color: 0xE85D8A, pos: [-60, -10, -90], size: 50 },
    ];

    nebulaData.forEach(({ color, pos, size }) => {
      const count = 800;
      const geo = new THREE.BufferGeometry();
      const positions = new Float32Array(count * 3);
      const opacities = new Float32Array(count);

      for (let i = 0; i < count; i++) {
        const theta = Math.random() * Math.PI * 2;
        const phi = Math.random() * Math.PI;
        const r = Math.random() * size;
        positions[i * 3]     = pos[0] + r * Math.sin(phi) * Math.cos(theta);
        positions[i * 3 + 1] = pos[1] + r * Math.sin(phi) * Math.sin(theta);
        positions[i * 3 + 2] = pos[2] + r * Math.cos(phi);
        opacities[i] = Math.random() * 0.4 + 0.1;
      }

      geo.setAttribute('position', new THREE.BufferAttribute(positions, 3));
      geo.setAttribute('opacity', new THREE.BufferAttribute(opacities, 1));

      const mat = new THREE.ShaderMaterial({
        uniforms: {
          color: { value: new THREE.Color(color) },
          time: { value: 0 },
        },
        vertexShader: `
          attribute float opacity;
          varying float vOpacity;
          uniform float time;
          void main() {
            vOpacity = opacity;
            vec4 mvPos = modelViewMatrix * vec4(position, 1.0);
            gl_PointSize = 8.0 * (200.0 / -mvPos.z);
            gl_Position = projectionMatrix * mvPos;
          }
        `,
        fragmentShader: `
          uniform vec3 color;
          varying float vOpacity;
          void main() {
            float d = length(gl_PointCoord - 0.5);
            if (d > 0.5) discard;
            float alpha = (1.0 - smoothstep(0.0, 0.5, d)) * vOpacity;
            gl_FragColor = vec4(color, alpha * 0.3);
          }
        `,
        transparent: true,
        depthWrite: false,
        blending: THREE.AdditiveBlending,
      });

      const cloud = new THREE.Points(geo, mat);
      this.scene.add(cloud);
      this.nebula.push({ mesh: cloud, mat });
    });
  }

  createGridFloor() {
    const geo = new THREE.PlaneGeometry(400, 400, 60, 60);
    const mat = new THREE.ShaderMaterial({
      uniforms: {
        time: { value: 0 },
        colorA: { value: new THREE.Color(0xD4A843) },
        colorB: { value: new THREE.Color(0x00D4C8) },
      },
      vertexShader: `
        varying vec2 vUv;
        varying float vElevation;
        uniform float time;
        void main() {
          vUv = uv;
          vec3 pos = position;
          float wave = sin(pos.x * 0.05 + time * 0.5) * cos(pos.y * 0.05 + time * 0.3) * 2.0;
          pos.z += wave;
          vElevation = wave;
          gl_Position = projectionMatrix * modelViewMatrix * vec4(pos, 1.0);
        }
      `,
      fragmentShader: `
        varying vec2 vUv;
        varying float vElevation;
        uniform vec3 colorA;
        uniform vec3 colorB;
        void main() {
          float gridX = abs(fract(vUv.x * 60.0) - 0.5);
          float gridY = abs(fract(vUv.y * 60.0) - 0.5);
          float lineX = 1.0 - smoothstep(0.0, 0.04, gridX);
          float lineY = 1.0 - smoothstep(0.0, 0.04, gridY);
          float grid = max(lineX, lineY);
          float dist = length(vUv - 0.5);
          float fade = 1.0 - smoothstep(0.2, 0.5, dist);
          vec3 color = mix(colorA, colorB, vUv.x);
          float elev = (vElevation + 2.0) * 0.25;
          gl_FragColor = vec4(color * elev, grid * fade * 0.35);
        }
      `,
      transparent: true,
      depthWrite: false,
      side: THREE.DoubleSide,
    });

    this.grid = new THREE.Mesh(geo, mat);
    this.grid.rotation.x = -Math.PI / 2;
    this.grid.position.y = -25;
    this.grid.position.z = -30;
    this.scene.add(this.grid);
  }

  createGlowOrbs() {
    const orbs = [
      { color: 0xD4A843, pos: [-15, 8, -20], size: 1.5 },
      { color: 0x00D4C8, pos: [18, -5, -25], size: 1.2 },
      { color: 0x7B5CE4, pos: [0, 15, -30], size: 2 },
    ];

    orbs.forEach(({ color, pos, size }) => {
      const geo = new THREE.SphereGeometry(size, 32, 32);
      const mat = new THREE.MeshBasicMaterial({
        color,
        transparent: true,
        opacity: 0.8,
      });
      const mesh = new THREE.Mesh(geo, mat);
      mesh.position.set(...pos);

      // Glow corona
      const glowGeo = new THREE.SphereGeometry(size * 3, 32, 32);
      const glowMat = new THREE.ShaderMaterial({
        uniforms: { color: { value: new THREE.Color(color) } },
        vertexShader: `
          varying vec3 vNormal;
          void main() {
            vNormal = normalize(normalMatrix * normal);
            gl_Position = projectionMatrix * modelViewMatrix * vec4(position, 1.0);
          }
        `,
        fragmentShader: `
          varying vec3 vNormal;
          uniform vec3 color;
          void main() {
            float intensity = pow(0.5 - dot(vNormal, vec3(0,0,1)), 2.0);
            gl_FragColor = vec4(color, intensity * 0.4);
          }
        `,
        transparent: true,
        depthWrite: false,
        blending: THREE.AdditiveBlending,
        side: THREE.BackSide,
      });
      const glow = new THREE.Mesh(glowGeo, glowMat);
      mesh.add(glow);
      this.scene.add(mesh);
    });
  }

  createConstellations() {
    const points = [
      [10, 5, -40], [-10, 8, -45], [15, -3, -42],
      [-5, 12, -50], [20, 0, -38], [-15, -5, -48],
    ];

    const geo = new THREE.BufferGeometry();
    const pos = new Float32Array(points.length * 3);
    points.forEach((p, i) => {
      pos[i * 3] = p[0]; pos[i * 3 + 1] = p[1]; pos[i * 3 + 2] = p[2];
    });
    geo.setAttribute('position', new THREE.BufferAttribute(pos, 3));

    // Lines between points
    const linePairs = [[0,1],[1,2],[2,3],[3,4],[4,5],[5,0],[0,3],[2,4]];
    linePairs.forEach(([a, b]) => {
      const lineGeo = new THREE.BufferGeometry();
      const linePos = new Float32Array([
        points[a][0], points[a][1], points[a][2],
        points[b][0], points[b][1], points[b][2],
      ]);
      lineGeo.setAttribute('position', new THREE.BufferAttribute(linePos, 3));
      const lineMat = new THREE.LineBasicMaterial({
        color: 0xD4A843,
        transparent: true,
        opacity: 0.15,
      });
      this.scene.add(new THREE.Line(lineGeo, lineMat));
    });
  }

  createHologramPyramid() {
    this.pyramidGroup = new THREE.Group();
    this.pyramidGroup.position.set(16, 2, -26);

    // Outer wireframe pyramid (Golden)
    const pyrGeo = new THREE.ConeGeometry(7, 11, 4, 1, false);
    const pyrWire = new THREE.WireframeGeometry(pyrGeo);
    const pyrLine = new THREE.LineSegments(pyrWire, new THREE.LineBasicMaterial({
      color: 0xD4A843,
      transparent: true,
      opacity: 0.65,
    }));
    this.pyramidGroup.add(pyrLine);

    // Inner inverted core pyramid (Cyber Teal)
    const coreGeo = new THREE.ConeGeometry(3.5, 6, 4, 1, false);
    const coreWire = new THREE.WireframeGeometry(coreGeo);
    const coreLine = new THREE.LineSegments(coreWire, new THREE.LineBasicMaterial({
      color: 0x00D4C8,
      transparent: true,
      opacity: 0.85,
    }));
    coreLine.rotation.x = Math.PI;
    this.pyramidGroup.add(coreLine);

    // Glowing Apex Beacon
    const beaconGeo = new THREE.SphereGeometry(0.7, 16, 16);
    const beaconMat = new THREE.MeshBasicMaterial({ color: 0xF0C869 });
    const beacon = new THREE.Mesh(beaconGeo, beaconMat);
    beacon.position.y = 5.5;
    this.pyramidGroup.add(beacon);

    // Concentric Orbital Rings
    this.orbitalRings = [];
    const ringConfigs = [
      { radius: 9, color: 0xD4A843, tilt: 0.35, speed: 0.015 },
      { radius: 12, color: 0x00D4C8, tilt: -0.4, speed: -0.012 },
      { radius: 15, color: 0x7B5CE4, tilt: 0.55, speed: 0.009 },
    ];

    ringConfigs.forEach(cfg => {
      const ringGeo = new THREE.RingGeometry(cfg.radius - 0.08, cfg.radius + 0.08, 64);
      const ringMat = new THREE.MeshBasicMaterial({
        color: cfg.color,
        side: THREE.DoubleSide,
        transparent: true,
        opacity: 0.45,
      });
      const ring = new THREE.Mesh(ringGeo, ringMat);
      ring.rotation.x = Math.PI / 2 + cfg.tilt;
      this.pyramidGroup.add(ring);
      this.orbitalRings.push({ mesh: ring, speed: cfg.speed });
    });

    this.scene.add(this.pyramidGroup);
  }

  animate() {
    if (!this.renderer) {
      this.animFrame = requestAnimationFrame(() => this.animate());
      return;
    }

    this.time += 0.005;

    // Rotate starfield slowly
    if (this.particles) {
      this.particles.rotation.y = this.time * 0.01;
      this.particles.rotation.x = Math.sin(this.time * 0.005) * 0.05;
      this.particles.material.uniforms.time.value = this.time;
    }

    // Animate nebula
    this.nebula.forEach((n, i) => {
      n.mat.uniforms.time.value = this.time;
      n.mesh.rotation.z = this.time * 0.005 * (i % 2 ? 1 : -1);
    });

    // Animate grid
    if (this.grid) {
      this.grid.material.uniforms.time.value = this.time;
    }

    // Animate 3D Hologram Pyramid
    if (this.pyramidGroup) {
      this.pyramidGroup.rotation.y = this.time * 0.35;
      this.pyramidGroup.rotation.x = Math.sin(this.time * 0.25) * 0.12;
      this.pyramidGroup.position.y = 2 + Math.sin(this.time * 0.7) * 1.2;

      if (this.orbitalRings) {
        this.orbitalRings.forEach(r => {
          r.mesh.rotation.z += r.speed;
        });
      }
    }

    // Camera drift based on mouse
    this.camera.position.x += (this.mouse.x * 3 - this.camera.position.x) * 0.02;
    this.camera.position.y += (-this.mouse.y * 2 - this.camera.position.y) * 0.02;
    this.camera.lookAt(0, 0, 0);

    this.renderer.render(this.scene, this.camera);
    this.animFrame = requestAnimationFrame(() => this.animate());
  }

  bindEvents() {
    window.addEventListener('mousemove', (e) => {
      this.mouse.x = (e.clientX / window.innerWidth) * 2 - 1;
      this.mouse.y = (e.clientY / window.innerHeight) * 2 - 1;
    });

    window.addEventListener('resize', () => {
      if (!this.renderer) return;
      const W = window.innerWidth;
      const H = window.innerHeight;
      this.camera.aspect = W / H;
      this.camera.updateProjectionMatrix();
      this.renderer.setSize(W, H);
    });
  }

  destroy() {
    if (this.animFrame) cancelAnimationFrame(this.animFrame);
  }

  setLandscape(name) {
    const landscapes = {
      alula: {
        fogColor: 0x110803,
        glow: 'radial-gradient(circle at 50% 100%, rgba(212,168,67,0.18) 0%, transparent 60%), radial-gradient(circle at 80% 20%, rgba(255,140,50,0.08) 0%, transparent 50%)',
        exposure: 0.9,
      },
      kafd: {
        fogColor: 0x020712,
        glow: 'radial-gradient(circle at 50% 100%, rgba(0,212,200,0.18) 0%, transparent 60%), radial-gradient(circle at 20% 30%, rgba(212,168,67,0.1) 0%, transparent 50%)',
        exposure: 0.85,
      },
      neom: {
        fogColor: 0x010f0f,
        glow: 'radial-gradient(circle at 50% 100%, rgba(0,255,178,0.16) 0%, transparent 60%), radial-gradient(circle at 70% 30%, rgba(0,212,200,0.12) 0%, transparent 50%)',
        exposure: 0.95,
      },
      bilateral: {
        fogColor: 0x060312,
        glow: 'radial-gradient(circle at 20% 80%, rgba(123,92,228,0.16) 0%, transparent 60%), radial-gradient(circle at 80% 40%, rgba(212,168,67,0.14) 0%, transparent 50%)',
        exposure: 0.85,
      },
    };

    const cfg = landscapes[name] || landscapes.alula;

    if (this.scene && this.scene.fog) {
      this.scene.fog.color.setHex(cfg.fogColor);
    }
    if (this.renderer) {
      this.renderer.setClearColor(cfg.fogColor, 1);
      this.renderer.toneMappingExposure = cfg.exposure;
    }

    const glowEl = document.getElementById('nw-atmosphere-glow');
    if (glowEl) {
      glowEl.style.background = cfg.glow;
    }
  }
}

// ═══════════════════════════════════════════════
// NAVBAR SCROLL BEHAVIOR
// ═══════════════════════════════════════════════
class NawaderNavbar {
  constructor() {
    this.navbar = document.getElementById('nw-navbar');
    this.toggle = document.getElementById('nw-menu-toggle');
    this.menu   = document.getElementById('nw-mobile-menu');
    if (!this.navbar) return;
    this.init();
  }

  init() {
    // Scroll
    window.addEventListener('scroll', () => {
      if (window.scrollY > 30) {
        this.navbar.classList.add('scrolled');
      } else {
        this.navbar.classList.remove('scrolled');
      }
    }, { passive: true });

    // Mobile toggle
    if (this.toggle && this.menu) {
      this.toggle.addEventListener('click', () => {
        const isOpen = this.menu.classList.toggle('open');
        this.toggle.setAttribute('aria-expanded', isOpen);
        // Animate hamburger
        const spans = this.toggle.querySelectorAll('span');
        if (isOpen) {
          spans[0].style.transform = 'translateY(7px) rotate(45deg)';
          spans[1].style.opacity = '0';
          spans[2].style.transform = 'translateY(-7px) rotate(-45deg)';
        } else {
          spans.forEach(s => { s.style.transform = ''; s.style.opacity = ''; });
        }
      });
    }
  }
}

// ═══════════════════════════════════════════════
// SCROLL ANIMATIONS
// ═══════════════════════════════════════════════
class NawaderAnimations {
  constructor() {
    this.init();
  }

  init() {
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('nw-animated');
          observer.unobserve(entry.target);
        }
      });
    }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });

    document.querySelectorAll('[data-nw-animate]').forEach(el => {
      observer.observe(el);
    });
  }
}

// ═══════════════════════════════════════════════
// COUNTER ANIMATION
// ═══════════════════════════════════════════════
class NawaderCounters {
  constructor() {
    this.observed = new Set();
    this.init();
  }

  init() {
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting && !this.observed.has(entry.target)) {
          this.observed.add(entry.target);
          this.animateCounter(entry.target);
        }
      });
    }, { threshold: 0.5 });

    document.querySelectorAll('[data-counter]').forEach(el => observer.observe(el));
  }

  animateCounter(el) {
    const target = parseFloat(el.dataset.counter);
    const suffix = el.dataset.suffix || '';
    const prefix = el.dataset.prefix || '';
    const duration = 2000;
    const start = performance.now();

    const update = (now) => {
      const elapsed = now - start;
      const progress = Math.min(elapsed / duration, 1);
      const eased = 1 - Math.pow(1 - progress, 4);
      const current = target * eased;
      const formatted = current >= 1000
        ? (current / 1000).toFixed(1) + 'K'
        : current % 1 !== 0
        ? current.toFixed(1)
        : Math.floor(current).toString();
      el.textContent = prefix + formatted + suffix;
      if (progress < 1) requestAnimationFrame(update);
    };

    requestAnimationFrame(update);
  }
}

// ═══════════════════════════════════════════════
// PARTICLES HERO (CSS-based fallback)
// ═══════════════════════════════════════════════
class HeroParticles {
  constructor(container) {
    if (!container) return;
    this.container = container;
    this.create();
  }

  create() {
    for (let i = 0; i < 60; i++) {
      const p = document.createElement('div');
      p.className = 'nw-hero-particle';
      p.style.cssText = `
        position: absolute;
        width: ${Math.random() * 3 + 1}px;
        height: ${Math.random() * 3 + 1}px;
        background: ${Math.random() > 0.5 ? '#D4A843' : '#00D4C8'};
        border-radius: 50%;
        left: ${Math.random() * 100}%;
        top: ${Math.random() * 100}%;
        opacity: ${Math.random() * 0.6 + 0.1};
        animation: nw-float ${Math.random() * 8 + 4}s ease-in-out infinite;
        animation-delay: ${Math.random() * 5}s;
        pointer-events: none;
      `;
      this.container.appendChild(p);
    }
  }
}

// ═══════════════════════════════════════════════
// FEE CALCULATOR
// ═══════════════════════════════════════════════
class FeeCalculator {
  constructor() {
    this.form = document.getElementById('nw-fee-calc');
    if (!this.form) return;
    this.init();
  }

  init() {
    const inputs = this.form.querySelectorAll('select, input[type="radio"]');
    inputs.forEach(i => i.addEventListener('change', () => this.calculate()));
  }

  calculate() {
    const service = this.form.querySelector('[name="service"]')?.value || 'company';
    const type    = this.form.querySelector('[name="type"]')?.value || 'individual';
    const urgency = this.form.querySelector('[name="urgency"]')?.value || 'standard';

    const baseFees = {
      company: 2500, license: 1500, property: 3000,
      investment: 5000, trademark: 1200, visa: 800,
    };

    const typeMultiplier = { individual: 1, enterprise: 2.5, government: 1.8 };
    const urgencyMultiplier = { standard: 1, express: 1.5, priority: 2.2 };

    const base = baseFees[service] || 2000;
    const total = base * (typeMultiplier[type] || 1) * (urgencyMultiplier[urgency] || 1);
    const vat = total * 0.15;
    const grand = total + vat;

    this.updateDisplay(total, vat, grand);
  }

  updateDisplay(subtotal, vat, total) {
    const format = (n) => n.toLocaleString('ar-SA', { style: 'currency', currency: 'SAR' });

    const elSub = document.getElementById('calc-subtotal');
    const elVat = document.getElementById('calc-vat');
    const elTotal = document.getElementById('calc-total');

    if (elSub)   elSub.textContent = format(subtotal);
    if (elVat)   elVat.textContent = format(vat);
    if (elTotal) elTotal.textContent = format(total);

    // Animate total
    elTotal?.parentElement?.classList.add('nw-glow-pulse');
    setTimeout(() => elTotal?.parentElement?.classList.remove('nw-glow-pulse'), 1000);
  }
}

// ═══════════════════════════════════════════════
// MULTI-STEP WIZARD
// ═══════════════════════════════════════════════
class NawaderWizard {
  constructor() {
    this.wizard = document.getElementById('nw-wizard');
    if (!this.wizard) return;
    this.currentStep = 0;
    this.steps = this.wizard.querySelectorAll('[data-wizard-step]');
    this.indicators = this.wizard.querySelectorAll('[data-wizard-indicator]');
    this.init();
  }

  init() {
    this.showStep(0);

    this.wizard.querySelectorAll('[data-wizard-next]').forEach(btn => {
      btn.addEventListener('click', () => this.next());
    });
    this.wizard.querySelectorAll('[data-wizard-prev]').forEach(btn => {
      btn.addEventListener('click', () => this.prev());
    });
  }

  showStep(idx) {
    this.steps.forEach((step, i) => {
      step.style.display = i === idx ? 'block' : 'none';
      step.style.animation = i === idx ? 'nw-slide-up 0.4s ease forwards' : '';
    });
    this.indicators.forEach((ind, i) => {
      ind.classList.toggle('active', i === idx);
      ind.classList.toggle('done', i < idx);
    });
    this.currentStep = idx;
  }

  next() {
    if (this.currentStep < this.steps.length - 1) {
      this.showStep(this.currentStep + 1);
    }
  }

  prev() {
    if (this.currentStep > 0) {
      this.showStep(this.currentStep - 1);
    }
  }
}

// ═══════════════════════════════════════════════
// CATALOG FILTER & SEARCH
// ═══════════════════════════════════════════════
class CatalogFilter {
  constructor() {
    this.searchInput = document.getElementById('nw-catalog-search');
    this.filterBtns  = document.querySelectorAll('[data-filter]');
    this.cards       = document.querySelectorAll('[data-category]');
    if (!this.cards.length) return;
    this.init();
  }

  init() {
    if (this.searchInput) {
      this.searchInput.addEventListener('input', () => this.filter());
    }
    this.filterBtns.forEach(btn => {
      btn.addEventListener('click', () => {
        this.filterBtns.forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        this.filter();
      });
    });
  }

  filter() {
    const query = this.searchInput?.value?.toLowerCase() || '';
    const active = document.querySelector('[data-filter].active')?.dataset.filter || 'all';

    this.cards.forEach(card => {
      const cat  = card.dataset.category || '';
      const text = card.textContent.toLowerCase();
      const matchQuery  = !query || text.includes(query);
      const matchFilter = active === 'all' || cat === active;
      card.style.display = matchQuery && matchFilter ? '' : 'none';
      card.style.animation = matchQuery && matchFilter ? 'nw-fade-in 0.3s ease' : '';
    });
  }
}

// ═══════════════════════════════════════════════
// TOOLTIPS
// ═══════════════════════════════════════════════
class NawaderTooltips {
  constructor() {
    document.querySelectorAll('[data-tooltip]').forEach(el => {
      const tip = document.createElement('div');
      tip.className = 'nw-tooltip';
      tip.textContent = el.dataset.tooltip;
      el.style.position = 'relative';
      el.appendChild(tip);

      el.addEventListener('mouseenter', () => tip.classList.add('visible'));
      el.addEventListener('mouseleave', () => tip.classList.remove('visible'));
    });
  }
}

// ═══════════════════════════════════════════════
// NOTIFICATIONS
// ═══════════════════════════════════════════════
window.NawaderNotify = {
  show(message, type = 'info', duration = 4000) {
    const notif = document.createElement('div');
    notif.className = `nw-notification nw-notification-${type}`;
    notif.innerHTML = `
      <span class="nw-notification-icon">${this.icons[type]}</span>
      <span class="nw-notification-text">${message}</span>
      <button class="nw-notification-close" onclick="this.parentElement.remove()">×</button>
    `;

    let container = document.getElementById('nw-notifications');
    if (!container) {
      container = document.createElement('div');
      container.id = 'nw-notifications';
      container.style.cssText = `
        position:fixed; top:80px; left:1rem; z-index:9999;
        display:flex; flex-direction:column; gap:0.5rem;
        max-width:380px; width:calc(100% - 2rem);
      `;
      document.body.appendChild(container);
    }

    container.appendChild(notif);
    setTimeout(() => notif.classList.add('show'), 10);
    setTimeout(() => {
      notif.classList.remove('show');
      setTimeout(() => notif.remove(), 300);
    }, duration);
  },

  icons: {
    success: '✓',
    error: '✕',
    warning: '⚠',
    info: 'ℹ',
  },
};

// ═══════════════════════════════════════════════
// GLOBAL TOOLTIP & NOTIFICATION CSS
// ═══════════════════════════════════════════════
const globalStyles = document.createElement('style');
globalStyles.textContent = `
  .nw-tooltip {
    position: absolute;
    bottom: calc(100% + 8px);
    right: 50%;
    transform: translateX(50%);
    background: rgba(10,15,30,0.95);
    border: 1px solid rgba(212,168,67,0.2);
    border-radius: 6px;
    padding: 0.4rem 0.75rem;
    font-size: 0.78rem;
    color: var(--text-primary);
    white-space: nowrap;
    pointer-events: none;
    opacity: 0;
    transition: opacity 0.2s;
    z-index: 100;
  }
  .nw-tooltip.visible { opacity: 1; }

  .nw-notification {
    display: flex; align-items: center; gap: 0.75rem;
    padding: 0.9rem 1rem;
    background: rgba(10,15,30,0.95);
    backdrop-filter: blur(20px);
    border-radius: 12px;
    border: 1px solid rgba(255,255,255,0.08);
    box-shadow: 0 10px 30px rgba(0,0,0,0.4);
    opacity: 0; transform: translateX(-20px);
    transition: all 0.3s var(--ease-out-expo);
    font-size: 0.875rem; color: var(--text-primary);
  }
  .nw-notification.show { opacity: 1; transform: translateX(0); }
  .nw-notification-success { border-color: rgba(0,212,200,0.3); }
  .nw-notification-error   { border-color: rgba(232,93,138,0.3); }
  .nw-notification-warning { border-color: rgba(212,168,67,0.3); }
  .nw-notification-info    { border-color: rgba(123,92,228,0.3); }
  .nw-notification-icon { font-size: 1rem; flex-shrink: 0; }
  .nw-notification-text { flex: 1; }
  .nw-notification-close {
    background: none; border: none; cursor: pointer;
    color: var(--text-muted); font-size: 1.1rem;
    padding: 0 0.25rem; line-height: 1;
  }
  .nw-notification-close:hover { color: var(--text-primary); }
`;
document.head.appendChild(globalStyles);

// ═══════════════════════════════════════════════
// CYBERNETIC WEB AUDIO SYNTHESIZER
// ═══════════════════════════════════════════════
class NawaderCyberAudio {
  constructor() {
    this.ctx = null;
    this.muted = false;
    this.init();
  }

  init() {
    const AudioContext = window.AudioContext || window.webkitAudioContext;
    if (!AudioContext) return;

    const startAudio = () => {
      if (!this.ctx) this.ctx = new AudioContext();
      if (this.ctx.state === 'suspended') this.ctx.resume();
      window.removeEventListener('click', startAudio);
      window.removeEventListener('keydown', startAudio);
    };
    window.addEventListener('click', startAudio, { once: true });
    window.addEventListener('keydown', startAudio, { once: true });
  }

  playBlip(freq = 1100, duration = 0.04) {
    if (this.muted || !this.ctx || this.ctx.state !== 'running') return;
    try {
      const osc = this.ctx.createOscillator();
      const gain = this.ctx.createGain();
      osc.type = 'sine';
      osc.frequency.setValueAtTime(freq, this.ctx.currentTime);
      gain.gain.setValueAtTime(0.03, this.ctx.currentTime);
      gain.gain.exponentialRampToValueAtTime(0.0001, this.ctx.currentTime + duration);
      osc.connect(gain);
      gain.connect(this.ctx.destination);
      osc.start();
      osc.stop(this.ctx.currentTime + duration);
    } catch(e) {}
  }

  playWarp() {
    if (this.muted || !this.ctx || this.ctx.state !== 'running') return;
    try {
      [440, 554.37, 659.25, 880].forEach((freq, idx) => {
        const osc = this.ctx.createOscillator();
        const gain = this.ctx.createGain();
        osc.type = 'triangle';
        osc.frequency.setValueAtTime(freq, this.ctx.currentTime + idx * 0.03);
        gain.gain.setValueAtTime(0.025, this.ctx.currentTime + idx * 0.03);
        gain.gain.exponentialRampToValueAtTime(0.0001, this.ctx.currentTime + 0.35);
        osc.connect(gain);
        gain.connect(this.ctx.destination);
        osc.start(this.ctx.currentTime + idx * 0.03);
        osc.stop(this.ctx.currentTime + 0.35);
      });
    } catch(e) {}
  }

  playHologramOpen() {
    this.playWarp();
  }
}

// ═══════════════════════════════════════════════
// 3D SPATIAL CARD TILT PHYSICS
// ═══════════════════════════════════════════════
class NawaderSpatialCards {
  constructor() {
    this.cards = document.querySelectorAll('.nw-tilt, .nw-space-card, .nw-cat-card, .nw-platform-mockup');
    this.init();
  }

  init() {
    this.cards.forEach(card => {
      card.addEventListener('mousemove', e => this.handleMove(e, card));
      card.addEventListener('mouseleave', () => this.handleLeave(card));
      card.addEventListener('mouseenter', () => {
        if (window.nawaderAudio) window.nawaderAudio.playBlip(1250, 0.03);
      });
    });
  }

  handleMove(e, card) {
    const rect = card.getBoundingClientRect();
    const x = e.clientX - rect.left;
    const y = e.clientY - rect.top;
    const centerX = rect.width / 2;
    const centerY = rect.height / 2;

    const rotateX = ((y - centerY) / centerY) * -6;
    const rotateY = ((x - centerX) / centerX) * 6;

    card.style.transform = `perspective(1000px) rotateX(${rotateX.toFixed(2)}deg) rotateY(${rotateY.toFixed(2)}deg) translateY(-5px) scale3d(1.012, 1.012, 1.012)`;

    const glare = card.querySelector('.nw-card-glare');
    if (glare) {
      glare.style.opacity = '1';
      glare.style.background = `radial-gradient(circle at ${x}px ${y}px, rgba(212, 168, 67, 0.16) 0%, transparent 60%)`;
    }
  }

  handleLeave(card) {
    card.style.transform = '';
    const glare = card.querySelector('.nw-card-glare');
    if (glare) glare.style.opacity = '0';
  }
}

// ═══════════════════════════════════════════════
// INIT ALL
// ═══════════════════════════════════════════════
document.addEventListener('DOMContentLoaded', () => {
  window.nawaderAudio    = new NawaderCyberAudio();
  // Light production theme: the legacy dark WebGL scene is intentionally disabled.
  window.nawaderSpace    = null;
  window.nawaderNav      = new NawaderNavbar();
  window.nawaderAnims    = new NawaderAnimations();
  window.nawaderCounters = new NawaderCounters();
  window.nawaderCalc     = new FeeCalculator();
  window.nawaderWizard   = new NawaderWizard();
  window.nawaderCatalog  = new CatalogFilter();
  window.nawaderTips     = new NawaderTooltips();
  window.nawaderSpatial  = new NawaderSpatialCards();

  // Hero particles
  const heroParticleContainer = document.querySelector('.nw-hero-particles');
  if (heroParticleContainer) new HeroParticles(heroParticleContainer);

  // Smooth scroll for anchor links
  document.querySelectorAll('a[href^="#"]').forEach(a => {
    a.addEventListener('click', e => {
      const target = document.querySelector(a.getAttribute('href'));
      if (target) {
        e.preventDefault();
        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
      }
    });
  });
});
