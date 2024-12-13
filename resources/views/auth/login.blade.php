<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Login - Telecom</title>
    <link rel="icon" href="https://www.colas.com/favicon-32x32.png?v=a3aaafc2f61dca56c11ff88452088fe0" type="image/png">
    <link rel="stylesheet" href="{{asset('/assets/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('/assets/css/Nunito.css')}}">
</head>

<body class="bg-gradient-primary" style="background: #0a4866;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9 col-lg-12 col-xl-4 col-xxl-4" style="padding-top: 61px;">
                <div class="card shadow-lg o-hidden border-0 my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-6 col-xl-12 col-xxl-12">
                                <div class="p-5">
                                    <div class="text-center mb-5" style="padding-top: 0px;margin-top: -30px;">
                                        <img width="258" height="90" src="{{asset('/assets/img/COLAS%20WE%20OPEN%20THE%20WAY.png')}}"></div>
                                    <div class="text-center mb-5">
                                        <h4 class="text-dark">Connectez vous en tant qu'administrateur</h4>
                                    </div>
                                    <form method="post" action="{{ url('/loginCheck') }}" class="user">
                                        @csrf
                                        <div class="mb-3">
                                            <input value="telecom@telecom.mg" name="identifiant" class="form-control form-control-user" type="text" placeholder="Adresse e-mail ou login" required>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <input value="telecom" name="password" class="form-control form-control-user" type="password" placeholder="Mot de passe" required>
                                        </div>
                                        
                                        @if ($errors->any())
                                            <div class="alert alert-danger p-0 text-center">
                                                    @foreach ($errors->all() as $error)
                                                        {{ $error }}
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif

                                        <button class="btn btn-primary d-block btn-user w-100 mt-5" type="submit">Se connecter</button>
                                        <hr>
                                    </form>
                                    <div class="text-center">
                                        <a class="small" href="{{ url('/loginGuest') }}">Se connecter en tant qu'invité?</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{asset('/assets/bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('/assets/js/bs-init.js')}}"></script>
    <script src="{{asset('/assets/js/theme.js')}}"></script>
</body>

</html>
