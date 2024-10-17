<h3 class="text-center">Список пользователей в хранилище</h3>

{% if isAdmin %}
<a href="/user/edit/">
    <div class="btn btn-outline-primary">Создать пользователя</div>
</a>
<!-- <a href="/user/edit/">Create User</a> -->
{% endif %}</li>

<div class="table-responsive-sm">
    <table class="table table-stripped">
        <thead>
            <tr>
                <th scope="col">Имя</th>
                <th scope="col">Фамилия</th>
                <th scope="col">Дата рождения</th>
                {% if isAdmin %}
                <th scope="col">Редактирование</th>
                <th scope="col">Удаление</th>
                {% endif %}
            </tr>
        </thead>
        <tbody id="userTable">
            {% for user in users %}
            <tr class="">
                <td scope="row">{{ user.getUserName }}</td>
                <td>{{ user.getUserLastName() }}</td>
                <td>{% if user.getUserBirthday() is not null %}
                    {{ user.getUserBirthday() | date('d.m.Y') }}
                    {% else %}
                    <i><b>День рождения не указан</b></i>
                    {% endif %}
                </td>
                {% if isAdmin %}
                <td><a href="/user/edit/?user_id={{ user.getUserId }}">Edit</a></td>
                <td><a href="/user/remove/?user_id={{ user.getUserId }}">Remove</a></td>
                {% endif %}
            </tr>
            {% endfor %}
        </tbody>
    </table>

    <script>
        async function updateTable () {
            try {
                let result = await fetch('/user/indexRefresh/').then(res => res.json())
                document.querySelector('#userTable').innerHTML = result.map(user => {
                        return `
                        <tr class="">
                            <td scope="row">${user.username}</td>
                            <td>${user.userlastname}</td>
                            <td>${user.userbirthday}</td>
                            ${user.useredit ? `<td><a href="${user.useredit}">Edit</a></td>` : ''}
                            ${user.userremove ? `<td><a href="${user.userremove}" onClick=${removeUser(user.userId)}">Remove</a></td>` : ''}
                        </tr>
                        `
                    }).join('')
                // console.log(result)
            } catch (error) {
                document.querySelector('#userTable').innerHTML = '<p>Ошибка загрузки данных</p>'
            }
        }

        const removeUser = async (id) => {
            let result = await fetch(`/user/remove/?user_id=${id}`).then(res => res.json())
            if (result) {
                updateTable()
            }
        }

        setInterval(async () => {
            updateTable()
        }, 10000)
    </script>
</div>