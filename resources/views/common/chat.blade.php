<script type="text/javascript" class="optanon-category-C0003">
  var settings = {
    app_id: "{{ env('INTERCOM_APP_ID') }}"
  };

  var name = "{{ Auth::user() ? Auth::user()->name : null }}";
  var email = "{{ Auth::user() ? Auth::user()->email : null }}";
  var createdAt = "{{ Auth::user() ? Auth::user()->created_at : null }}";

  if(name && name != ""){
  	settings["name"] = name;
  	settings["email"] = email;
  	settings["created_at"] = createdAt;
  }

  window.intercomSettings = settings;
</script>

<script type="text/javascript" class="optanon-category-C0003">(function(){var w=window;var ic=w.Intercom;if(typeof ic==="function"){ic('reattach_activator');ic('update',w.intercomSettings);}else{var d=document;var i=function(){i.c(arguments);};i.q=[];i.c=function(args){i.q.push(args);};w.Intercom=i;var l=function(){var s=d.createElement('script');s.type='text/javascript';s.async=true;s.src='https://widget.intercom.io/widget/vrcqub1h';var x=d.getElementsByTagName('script')[0];x.parentNode.insertBefore(s,x);};if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})();
</script>
