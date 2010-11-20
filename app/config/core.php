<?php
	Configure::write('debug', 2);
	Configure::write('log', true);
	Configure::write('App.encoding', 'UTF-8');
	//Configure::write('Cache.disable', true);
	define('LOG_ERROR', 2);
	Configure::write('Session.save', 'database');
	Configure::write('Session.model', 'Session');
	Configure::write('Session.table', 'sessions');
	Configure::write('Session.cookie', 'KSUSSS');
	Configure::write('Session.timeout', '120');
	Configure::write('Session.start', true);
	Configure::write('Session.checkAgent', true);
	Configure::write('Security.level', 'medium');
	Configure::write('Security.salt', 'ahskdjfhlk5@^42hjkghaS2j35dhglridhlfkhrj');
	Configure::write('Security.cipherSeed', 7852397856987236587923657894236);
	Configure::write('Asset.timestamp', true);
	//date_default_timezone_set('UTC');
	Cache::config('default', array('engine' => 'File'));