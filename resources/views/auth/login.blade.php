<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ env('APP_NAME', 'Laravel Login') }}</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Favicon-->
    <link rel="stylesheet" href="/css/all.css">
    <link rel="shortcut icon" href="/assets/images/logo.png">

  </head>
  <body>
    <div class="login-page">
        <div class="container d-flex align-items-center">
            <div class="form-holder has-shadow">
            <div class="row">
                <!-- Logo & Information Panel-->
                <div class="col-lg-6">
                <div class="info d-flex align-items-center">
                    {{-- <div class="content">
                        <div class="logo">
                          <h1>Osuomra</h1>
                        </div>
                        <p>Sistema de gestión</p>
                    </div> --}}
                </div>
                </div>
                <!-- Form Panel    -->
                <div class="col-lg-6">
                <div class="form d-flex align-items-center">
                    <div class="content">
                    <form method="post" class="form-validate mb-4" action="/login">
                        @csrf
                        <div class="form-group">
                        <input id="username" type="text" name="username" required data-msg="Por favor ingrese su usuario" class="input-material">
                        <label for="login-username" class="label-material">Nombre de Usuario</label>
                        @error('username') <div id="login-password-error" class="is-invalid invalid-feedback">{{ $message }}</div>  @enderror
                        </div>
                        <div class="form-group">
                        <input id="password" type="password" name="password" required data-msg="Por favor ingrese su contraseña" class="input-material">
                        <label for="login-password" class="label-material">Contraseña</label>
                        @error('password') <div id="login-password-error" class="is-invalid invalid-feedback">{{ $message }}</div>  @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Iniciar sesión</button>
                    </form>
                    </div>
                </div>
                </div>
            </div>
            </div>
        </div>

        <div class="copyrights text-center">
            <p><a href="https://codesolutions.com.ar" class="external">Un software de Bruno Contartese</a></p>
        </div>
    </div>

    <!-- JavaScript files-->
    <script src="/js/all.js"></script>
  </body>
</html>
