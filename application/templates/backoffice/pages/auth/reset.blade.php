@extends('layouts.standalone')

@section('title', ucfirst($translations["frontoffice"]["login_button"]))

@section('content')


    <video autoplay muted loop id="authLoginVideo">
        <source src="/static/images/standalone.mp4" type="video/mp4">
    </video>


<main class="default-transition login-page" style="opacity: 1;">
    <div class="container">
        <div class="row h-100">
            <div class="col-12 col-md-10 mx-auto my-auto">
                <div class="card no-click auth-card">
                    <div class="position-relative image-side ">
                        
                        <p class=" text-white h3">BEM-VINDO</p> <br>
                        <p class="white mb-0">Eu não sou um produto das minhas circunstâncias.<br> Eu sou um produto das minhas decisões!</p>
                    </div> 

                    <div class="form-side">
                        
                        <a href="/"><span class="logo-single" style="background: url({{ $website_config->logo }}) no-repeat; background-size: contain;"></span></a>
                   <!--     <a href="/"><span class="logo-single"></span></a>   -->
                        <h6 class="mb-4">Recuperação de palavra-passe</h6>
                            @if (isset($_GET["message"]) && isset($_GET["success"]))
                                <br>
                                    <div class="alert alert-success alert-dismissible" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <strong>Sucesso!</strong> {{ $_GET["message"] }}
                                    </div>
                            @elseif(isset($_GET["message"]))
                                <br>
                                    <div class="alert alert-danger alert-dismissible" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <strong>Opsss deu um erro!</strong> {{ $_GET["message"] }}
                                    </div>
                            @endif

                            <form action="/forgot" method="POST">
                                <label class="form-group has-float-label mb-4">
                                    <input type="email" placeholder="O seu email" id="email" name="email" class="form-control" required>
                                    <span>Email</span>
                                </label>

                                <div class="d-flex justify-content-between align-items-center">
                                    <a href="/adm/login">Voltar</a>
                                    <button class="btn btn-outline-primary btn-lg" type="submit">Recuperar a palavra-passe</button>
                                </div>
                            </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>








<!--
	<main>
        <div class="container">
            <div class="row h-100">
                <div class="col-12 col-md-10 mx-auto my-auto">
                    <div class="card auth-card">
                        <div class="form-side w-100">
                            <a href="/"><span class="logo-single" style="background: url({{ $website_config->logo }}) no-repeat; background-size: contain;"></span></a>
                            <h6 class="mb-4">Login</h6>
                            @if (isset($_GET["message"]))
                                <br>
                                    <div class="alert alert-danger alert-dismissible" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <strong>Erro!</strong> {{ $_GET["message"] }}
                                    </div>
                            @endif
                            <form action="/login" method="POST">
                                <label class="form-group has-float-label mb-4">
                                    <input type="email" placeholder="O seu email" id="email" name="email" class="form-control"/>
                                    <span>Email</span>
                                </label>

                                <label class="form-group has-float-label mb-4">
                                    <input class="form-control" placeholder="A sua palavra-passe" id="password" name="password" type="password" placeholder="" />
                                    <span>Palavra-passe</span>
                                </label>
                                <div class="d-flex justify-content-between align-items-center">
                                    <button type="submit" class="btn btn-outline-primary btn-lg" type="submit">Iniciar sessão</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    -->

@endsection
