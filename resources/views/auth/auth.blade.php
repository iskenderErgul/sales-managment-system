<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Sayfası</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            box-sizing: border-box;
        }

        button {
            background-color: #4caf50;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }
    </style>
</head>
<body>

<form id="loginForm" method="post" action="{{route('login')}}">
    @if($errors->any())
        @foreach($errors->all() as $errors)
            <h3>{{$errors}}</h3>
        @endforeach
    @endif
    @csrf
    <label for="username">Email</label>
    <input type="email" id="email" name="email" required value="{{old('email')}}">

    <label for="password">Şifre</label>
    <input type="password" id="password" name="password" required>

    <button type="submit">Giriş Yap</button>
</form>


</body>
</html>
