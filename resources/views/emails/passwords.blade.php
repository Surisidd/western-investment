@component('mail::message')
## Western Client Statement Password <br>
---

Dear {{$name}},<br>
Welcome to Western Capital, <br>
We have generated a unique code to protect your Statements. <br>


**Kindly save this code as it will be your password for accessing all future statements from us.** <br>

Thank you for Investing with us.

Password : {{$contact->password()}} <br>
---
**Note:** Dont **Share Your Password** with anyone. <br>
<br>
Thanks,<br>
Western Capital <br>
{{ config('app.name') }}
@endcomponent