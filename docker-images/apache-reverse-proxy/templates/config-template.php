<?php
$static_app1 = getenv('STATIC_APP1');
$static_app2 = getenv('STATIC_APP2');
$dynamic_app1 = getenv('DYNAMIC_APP1');
$dynamic_app2 = getenv('DYNAMIC_APP2');
$portainer = getenv('PORTAINER_APP');
?>
<VirtualHost *:80>

	ServerName demo.res.ch

	Header add Set-Cookie "ROUTE=.%{BALANCER_WORKER_ROUTE}e; path=/" env=BALANCER_ROUTE_CHANGED
	<Proxy balancer://staticCluster>
	    BalancerMember http://<?php print "$static_app1"?> loadfactor=1 route=static1
	    BalancerMember http://<?php print "$static_app2"?> loadfactor=1 route=static2
	    ProxySet lbmethod=byrequests
	    ProxySet stickysession=ROUTE
	</Proxy>

	<Proxy balancer://dynamicCluster>
	    BalancerMember http://<?php print "$dynamic_app1"?> loadfactor=1 route=dynamic1
	    BalancerMember http://<?php print "$dynamic_app2"?> loadfactor=1 route=dynamic2
	    ProxySet lbmethod=byrequests
	    ProxySet stickysession=ROUTE
	</Proxy>

	ProxyPreserveHost On

	ProxyPass '/portainer/' http://<?php print "$portainer"?>/
		ProxyPassReverse '/portainer/' http://<?php print "$portainer"?>/

	ProxyPass '/api/students/' balancer://dynamicCluster/
	ProxyPassReverse '/api/students/' balancer://dynamicCluster/

	ProxyPass '/' balancer://staticCluster/
	ProxyPassReverse '/' balancer://staticCluster/

</VirtualHost>
