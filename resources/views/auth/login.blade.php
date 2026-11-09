<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Lost & Found</title>

  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f3f7f6;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }
    .container {
      background: #fff;
      padding: 40px;
      border-radius: 10px;
      box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
      text-align: center;
      width: 350px;
    }
    h2 {
      margin-bottom: 20px;
      font-size: 24px;
      color: #1a3b7a;
      font-weight: bold;
    }
    .error {
      color: red;
      font-size: 14px;
      margin-bottom: 10px;
    }
    input {
      width: 100%;
      padding: 12px;
      margin: 10px 0;
      border: 1px solid #ddd;
      border-radius: 6px;
      font-size: 14px;
    }
    button {
      width: 100%;
      padding: 12px;
      background-color: #1a3b7a;
      color: white;
      border: none;
      border-radius: 6px;
      font-size: 16px;
      cursor: pointer;
    }
  </style>
</head>
<body>

<div class="container">
  <h2>Lost & Found</h2>

 
  @error('login')
    <p class="error">{{ $message }}</p>
  @enderror

  <form method="POST" action="{{ route('login') }}">
    @csrf
    <input type="text" name="username" placeholder="Username or Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Login</button>
  </form>

  <div class="links">
    <p>New here? <a href="{{ route('register') }}">Sign up</a></p>
  </div>
</div>

</body>
</html>
