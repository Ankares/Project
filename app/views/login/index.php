{% extends '/layout/layout.html.twig' %}
{% block title %}
    Login
{% endblock %}
{% block body %}
    <a class="btn btn-outline-primary m-4" href="/home">Главная</a>
    <div class="container p-4">
        <form action="/login" method="post" onchange="checkLoginForm(['.inp_email', '.inp_pass'], '.forButton')" class="form-control mt-1 p-4 mx-auto justify-content-center w-50 ">  
            <h2 class="text-center mb-4">Login</h2>
            <div class="form-group fs-4">
                <label class="mb-2">Email:</label>
                <input type="email" name="email" class="inp_email form-control mb-2" placeholder="Enter email">  
            </div>
            <div class="form-group fs-4">
                <label class="mb-2">Password:</label>
                <input type="password" name="password" class="inp_pass form-control mb-2" placeholder="Enter your password">  
            </div>
            
            {% if error %}
                <div class="error mt-3 fw-bold fs-4 text-danger">{{error|escape}}</div>
            {% endif %}
        
            <div class="forButton">

            </div>
        </form>
    </div>
{% endblock %}

{%  block js %}
    <script src="/app/js/script.js"></script>
{% endblock %}
