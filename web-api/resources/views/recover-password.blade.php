<html>
    <body>
        <form action="/api/reset-password" method="POST">
            {{ csrf_field() }}
            {{ method_field('POST') }}

            {{ $email }}

            <label for="password">Password:</label>
            <input type="text" id="password" name="Password"><br>
            <br>
            <label for="confirmPassword">Confirmar password:</label>
            <input type="text" id="confirmPassword" name="Confirm Password"><br>
            <button type="submit">Reset Password</button>
        </form>
    </body>
</html>
