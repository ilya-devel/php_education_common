<form action="{{ action }}" method="post">
  <input id="csrf_token" type="hidden" name="csrf_token" value="{{ csrf_token }}">
  <p>
    <label for="user-name">Имя:</label>
    <input id="user-name" type="text" name="name" {% if user %} value="{{ user.getUserName() }}" {% endif %}>
  </p>
  <p>
    <label for="user-lastname">Фамилия:</label>
    <input id="user-lastname" type="text" name="lastname" {% if user %} value="{{ user.getUserLastName() }}" {% endif %}>
  </p>
  <p>
    <label for="user-birthday">День рождения:</label>
    <input id="user-birthday" type="text" name="birthday" placeholder="ДД-ММ-ГГГГ" {% if user %} value="{{ user.getUserBirthday() | date('d-m-Y') }}" {% endif %}>
  </p>
  <p><input type="submit" value="Сохранить"></p>
</form>