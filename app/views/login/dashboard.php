{% extends '/layout/layout.html.twig' %}
{% block title %}
    Dashboard
{% endblock %}
{% block body %}
    <div class="container mt-5 text-center p-4">
        <h1>Welcome back, {{user['name']|escape}}</h1>
        <a class="btn btn-outline-primary fs-4 mt-4 col-5" href="/home">Home</a>
        <form action="/login/dashboard" method="post">
            <input type="hidden" name="logout">
            <button class="btn btn-outline-danger fs-4 mt-3 col-5">Log out</button>
        </form>
    </div>
{% endblock %}
    
{%  block js %}
    <script src="/app/js/script.js"></script>
{% endblock %}