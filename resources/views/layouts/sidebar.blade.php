<aside id="sidebar-wrapper">
    <div class="sidebar-brand">
        <img class="navbar-brand-full app-header-logo" src="{{ asset('img/logo-cambre.png') }}" width="100"
             alt="Infyom Logo">
        <a href="{{ url('/') }}"></a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
        <a href="{{ url('/') }}" class="small-sidebar-text">
            <img class="navbar-brand-full" src="{{ asset('img/logo-cambre-ol.png') }}" width="70px" alt=""/>
        </a>
    </div>
    <ul class="sidebar-menu">
        @include('layouts.menu')
    </ul>
</aside>

<script>
    const mutationObserver = new MutationObserver(mutationsList => {
      mutationsList.forEach(mutation => {
		if (mutation.attributeName === 'class') {
			// classes have changed
            if( $('#body').hasClass('sidebar-mini') )
            {
                $('.borde-menu').addClass('border border-primary border-2')
            }else{
                $('.borde-menu').removeClass('border border-primary border-2');
            }  
		}
	});
});

mutationObserver.observe(
	// a document object you want to watch. some examples of document objects:
	 document.getElementById('body')
	// document.getElementsByClassName('class')[5]
	// document.querySelector('[query=selector]')
	// etc
	,{ attributes: true }
)

// when you wanr to remove the listener
//mutationObserver.disconnect();
</script>