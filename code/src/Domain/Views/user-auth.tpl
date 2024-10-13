{% if auth_error is not null and auth_error %}
  <p>{{ error_msg }}</p>
{% endif %}



<form action="/user/login/" method="post">
  <input id="csrf_token" type="hidden" name="csrf_token" value="{{ csrf_token }}">
  <p>
    <label for="user-login">Логин:</label>
    <input id="user-login" type="text" name="login">
  </p>
  <p>
    <label for="user-password">Пароль:</label>
    <input id="user-password" type="password" name="password">
  </p>
  <p><input type="submit" value="Войти"></p>
</form>