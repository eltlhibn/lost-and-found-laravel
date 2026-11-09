<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register - Lost & Found</title>

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
    button:hover { background-color: #142d5c; }
    .links { margin-top: 15px; font-size: 14px; }
    .links a { color: #1a3b7a; text-decoration: none; font-weight: 500; }
    .message { margin-bottom: 15px; font-size: 14px; color: red; }
  </style>
</head>
<body>

<div class="container">
  <h2>Create Account</h2>

  @if ($errors->any())
    <div class="message">{{ $errors->first() }}</div>
  @endif

  <form method="POST" action="{{ route('register') }}">
    @csrf

    <input type="text" name="name" placeholder="Full Name" value="{{ old('name') }}" required>
    <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
    <input type="text" name="username" placeholder="Username" value="{{ old('username') }}" required>
    <input type="password" name="password" placeholder="Password" required>
    <input type="password" name="password_confirmation" placeholder="Confirm Password" required>

    <button type="submit">Register</button>
  </form>

  <div class="links">
    <p>Already have an account?
      <a href="{{ route('login') }}">Login</a>
    </p>
  </div>
</div>

</body>
</html>
