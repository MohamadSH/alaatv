<!DOCTYPE html>
<html lang = "fa">
<head>
    <meta charset = "utf-8">
</head>
<body style = "direction: rtl;">
<h2>آلاء - تماس با ما</h2>

<div>
    <ul>
        <li>
            ایمیل فرستنده : {{ $email }}
        </li>
        <li>
            شماره تماس فرستنده: {{ $phone }}
        </li>
        <li>
            نام فرستنده: {{ $name }}
        </li>
    </ul>
</div>

<div>
    <h4 style = "text-decoration: underline;">پیام :</h4>
    {{ $comment  }}
</div>
<br/>


</body>

</html>