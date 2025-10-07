<h2>Login</h2>

@if ($errors->any()) 
    <p style="color:red">{{$erros->first()}}</p>
    @endif
    
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <label>email:</label><br>
        <input type=email" name ="email" required><br>

        <label>password:</label><br>
        <input type="password" name="password" required><br><br>

        <button type="submit">Login</button>
</form>

<p>Belum punya akun? <a href="{{ route( 'register') }}">Daftar</a><p>