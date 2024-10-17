{% if not user_authorized %}
<a href="/user/auth/"><div class="btn btn-outline-primary me-2">Вход в систему</div></a>
<!-- <p><a href="/user/auth/">Вход в систему</a></p> -->
{% else %}
<!-- <p>Login: {{ user_name }}</p> -->
<div><a href="/user/logout/"><div class="btn btn-outline-primary me-2">Выход ({{ user_name }})</div></a></div>
<!-- <p>Добро пожаловать на сайт! {{ user_name }}</p>
<p><a href="/user/logout/">Выход из системы</a></p> -->
{% endif %}