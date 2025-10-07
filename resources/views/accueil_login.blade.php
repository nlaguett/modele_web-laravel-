<?php


?>
<html>
<head>
<title>Login</title>
<style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: #0575E6;
            background: linear-gradient(90deg, rgba(5, 117, 230, 1) 0%, rgba(2, 27, 121, 1) 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            height: 100vh;
        }

        #toolbarContainer{
            margin-top:100px;
        }

        .login {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 470px;
        }

        .login-container {
            background-color: white;
           /* padding: 30px;*/
            border-radius: 10px;
            text-align: center;
            width: 500px;
           /* max-width: 400px;*/
            padding-bottom : 0;
        }

        .login-container form{
            padding:20px;
        }
        .login-container h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        .login-container label {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }
        .login-container input {
            width: 100%;
            padding: 10px;
            margin-bottom: 30px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
        }
        .login-container button {
            width: 100%;
            padding: 10px;
            background-color: #0056b3;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        .login-container button:hover {
            background-color: #003f8a;
            transition: all 0.5s;
        }
        .login-container .error {
            color: red;
            text-align: center;
            margin-bottom: 10px;
        }

        .logo_web img{
            border-radius: 10px 10px 0 0;
           /* width: 460px;*/
           height:200px;
            max-width: 470px;
        }
        .login-logo {
            display:none;
            max-width: 100%;
            width: 460px;
            height: auto; /* Garde les proportions */
            margin-left: auto;
            margin-right: auto;
            border-radius: 0 0 10px 10px;
        }
        .logo{
            width:400px;
            padding-bottom:30px;
        }
        @media screen and (max-width: 767px) {
         .login-container {
            background-color: white;
            border-radius: 10px;
            text-align: center;
            width: 100%;
            max-width: 400px;
            padding-bottom : 0px;
           }
        }
        .background-login{
            background-image: url('{{ asset("images/test3.jpg") }}');
            background-size:cover;
        }
    </style>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate" />
<meta http-equiv="Pragma" content="no-cache" />
<meta http-equiv="Expires" content="0" />
</head>
<body class="background-login">
    <br/>

    <div class="login-container">
        <h2>Connexion à l'administration</h2>

        {{-- Afficher les messages d'erreur de session --}}
        @if(session('message'))
            <div class="error" id="error">
                {{ is_array(session('message')) ? (session('message')['login'] ?? '') : session('message') }}
            </div>
        @endif

        {{-- Afficher les erreurs de validation --}}
        @if($errors->any())
            <div class="error">
                @foreach($errors->all() as $error)
                    {{ $error }}<br>
                @endforeach
            </div>
        @endif

        <form method="post" name="login_connection" action="{{ route('login.post') }}">
            @csrf
            <label for="username">Identifiant (Email)</label>
            <input type="text" id="username" name="login" placeholder="Entrez votre email" required>

            <label for="password">Mot de passe</label>
            <input type="password" id="password" name="pass" placeholder="Entrez votre mot de passe" required>

            <button type="submit">Connexion</button>
            <h4 style="color:red;">Mot de passe perdu ?</h4>
        </form>
        <img src="{{ asset('images/model-web.webp') }}" alt="Mon Image" class="login-logo">
    </div>



</body>
</html>




