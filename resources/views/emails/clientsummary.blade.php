@component('mail::message')


Dear {{$first_name}},  <br>


We would like to recall the previous statement sent to you earlier.  <br>


We noted that there was an issue picking up contributions and redemption made in August which has been  resolved. <br>
Please find attached your amended statement for the month of August reflecting your actual holdings. <br>


<strong>Our sincerest apologies for this.</strong> <br>


Thank you for your continued patience.

{{-- Please find attached your Western portfolio statement  for the month of {{$date->format('F Y')}}. <br>
 
Please note that due to the system disruption, we could only provide your portfolio summary for the month. We hope to resume the normal format of reporting next month. <br>

<strong>Sincere apologies for any inconvenience caused.</strong> <br>

Thank you for entrusting us with your capital. Your feedback is tremendously useful. <br>
You can reach us anytime at clientservice@Westerncapital.com if you have any questions or comments. <br> --}}
   

We are now available on Whatsapp! Save our number 0709 902 700 and text us the word "'Yes" to receive information & updates via Whatsapp. <br>

Subscribe to our YouTube channel to learn more and continue making wise investment decisions. <br>

<br>
<br>

Kind Regards, <br>

Western Capital. <br>

{{ config('app.name') }}
@endcomponent
