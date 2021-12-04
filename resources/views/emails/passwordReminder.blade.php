@component('mail::message')
## Western Client Statement Password<br>
---

Dear {{$name}},<br>
Please find below your password for accessing your statements
<br>

**Kindly save this code as it will be your password for accessing all future statements from us.** <br>

Thank you for Investing with us.

Password : {{$contact->password()}} <br>
---
**Note:** Dont **Share Your Password** with anyone. <br>
<br>
Thanks,<br>
Western Capital <br>
Thanks,<br>
{{ config('app.name') }}
@endcomponent
