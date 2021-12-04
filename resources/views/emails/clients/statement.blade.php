@component('mail::message')


Dear {{$first_name}},  <br>

Please find attached your Western portfolio statement for the month of {{$date->format('F Y')}}. <br>
In order to ensure security and confidentiality, we have built in password protection feature. <br>
<h2>Kindly use your password to access your statement.</h2>

Thank you for entrusting us with your capital. Your feedback is tremendously useful.<br>
You can reach us anytime at clientservice@Westerncapital.com if you have any questions or comments.<br>
We are now available on Whatsapp! Save our number 0709 902 700 and text us the word "'Yes" to receive information & updates via Whatsapp. <br>
Subscribe to our YouTube channel to learn more and continue making wise investment decisions.

Kind Regards, <br>

Western Capital. <br>

{{ config('app.name') }}
@endcomponent
