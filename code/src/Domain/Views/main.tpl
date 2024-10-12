<!DOCTYPE html>
<html>
    <head>
        <title>{{ title }}</title>
    </head>
    <body>
        <div id="header">
            {% include "auth-template.tpl" %}
        </div>
        <p><a href="/">Home</a></p>
        <p><a href="/user/index">Users</a></p>

        {% include content_template_name %}
    </body>
</html>