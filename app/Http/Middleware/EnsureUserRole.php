<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (! $user) {
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'غير مصرح: يلزم تسجيل الدخول ببروتوكول التحقق السيادي.',
                ], 401);
            }

            return redirect()->guest(route('login'));
        }

        // Super Admin has global clearance
        if ($user->isAdmin()) {
            return $next($request);
        }

        // Check if user has one of the allowed roles
        if (! empty($roles) && ! in_array($user->role, $roles)) {
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'وصول محظور: مستوى الصلاحيات الحالي ('.$user->role.') لا يمتلك الاعتماد اللازم لتنفيذ هذا الإجراء السيادي.',
                ], 403);
            }
            abort(403, 'وصول محظور: مستوى الصلاحيات الحالي لا يمتلك الاعتماد السيادي للوصول لهذا القسم.');
        }

        return $next($request);
    }
}
