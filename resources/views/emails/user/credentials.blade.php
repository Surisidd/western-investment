@component('mail::message')
## Login Credentials To Western Client Dispatch System
---

Hi {{$user->name}},<br>
Here are your login credentials to the Western Client Statement Dispatch Tool <br>
Email : {{$user->email}} <br>
Password : {{$password}} <br>
Login here [ Western Client Service Dispatch ](https://statement.Western V.com/),<br>

---
>**Note:** Dont **Share Your Credentials** to anyone. <br>
<br>
Thanks,<br>
{{ config('app.name') }}
@endcomponent