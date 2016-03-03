<body bgcolor="#f5f7fa" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 10pt; color: #777777; line-height: 1.6em; -webkit-font-smoothing: antialiased; height: 100%; -webkit-text-size-adjust: none; width: 100% !important; margin: 0; padding: 0;">

  <table bgcolor="#f5f7fa" style="width: 100%; margin: 0; padding: 20px;">
    <tr>
      <td style="margin: 0; padding: 0;"></td>
      <td style="margin:0 auto!important; display: block !important; color: #777; padding: 0px;">

        <div style="background-color: #ffffff; display: block; max-width: 400px; margin: 0 auto; padding: 20px;">
	        <table style="width: 100%; margin: 0; padding: 0;">
	          <tr>
	            <td>

	              <div style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 10pt; color: #777777; line-height: 1.6em; margin: 0; padding: 0;">

	                @yield('message')

	              </div>
	            </td>
	          </tr>
	          <tr>
	            <td style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 8pt; color: #777777; line-height: 1.6em; margin: 0; padding: 20pt 0;">
	            	Sent from {{config('bear.site')}}. @if (!empty($token))If you do not wish to receive these emails, please <a href="{{url('unsubscribe')}}?t={{$token}}">unsubcribe</a>.@endif
	            </td>
	          </tr>
	        </table>
        </div>
      </td>
      <td style="margin: 0; padding: 0;"></td>
    </tr>
  </table>

</body>
