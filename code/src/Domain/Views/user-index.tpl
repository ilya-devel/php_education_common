<p>Список пользователей в хранилище</p>

{% if user_authorized %}
    <a href="/user/edit/">Create User</a>
{% endif %}</li>

<ul id="navigation">
    {% for user in users %}
        <li>
        {{ user.getUserName() }}
        {{ user.getUserLastName() }}.
        День рождения:

        {% if user.getUserBirthday() is not null %}
            {{ user.getUserBirthday() | date('d.m.Y') }}
        {% else %}
            <i><b>День рождения не указан</b></i>
        {% endif %}
        {% if user_authorized %}
            <a href="/user/edit/?user_id={{ user.getUserId }}">Edit</a>
        {% endif %}</li>
    {% endfor %}
</ul>