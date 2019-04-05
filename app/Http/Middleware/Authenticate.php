<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use App\Traits\ApiResponser;
class Authenticate extends Middleware
{
  use ApiResponser;

  public function handle($request, Closure $next, ...$guards)
  {
      if ($this->authenticate($request, $guards) === 'authentication_error') {
          return $this->errorResponse('No autenticado', 401);
      }
      return $next($request);
  }

  protected function authenticate($request, array $guards)
  {
      if (empty($guards)) {
          $guards = [null];
      }
      foreach ($guards as $guard) {
          if ($this->auth->guard($guard)->check()) {
              return $this->auth->shouldUse($guard);
          }
      }
      return 'authentication_error';
  }
}
