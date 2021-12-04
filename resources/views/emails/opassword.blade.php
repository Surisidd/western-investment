@component('mail::message')
## Western Client Statement Password <br>
---

Dear {{$name}},<br>
Hope this finds you well, <br>
For security and confidentiality we've generated a unique password for you to use to access all your monthly statements. <br>
Please note that this unique code is what you **shall use henceforth** to access any statement we send to you.<br>
We've noted that generating a different passcode each time may cause a bit of confusion and inconvenience on your part. <br>

**Kindly save this code to use for all future statements.** <br>

We apologize for any inconvenience or difficulties experienced before and trust this brings the much needed clarity. <br>


Password : {{$contact->password()}} <br>
---
**Note:** Dont **Share Your Password** with anyone. <br>
<br>
Thanks,<br>
Western Capital <br>
{{ config('app.name') }}
@endcomponent