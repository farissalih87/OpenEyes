node default {

	exec { 'apt-update':
		command => '/usr/bin/apt-get update',
	}

	include core::apache2
	include core::mysql
	include core::curl
	include core::git
	include core::mail
	include core::php5
	include core::wkhtmltox
	include core::openeyes
	include core::composer

	if $mode == 'dev' {
		include dev::vim
		include dev::xdebug
		include dev::nodejs
		include dev::grunt
		include dev::bower
		include dev::ruby
		include dev::compass
		include dev::security
		notice("Running advanced xdebug config")
		dev::xdebug::config { 'default':
			profiler_output_name => 'xdebug.log',
			remote_connect_back => 1,
			remote_enable => 1,
			remote_port => 9000
		}
	}

	if $mode == 'ci' {
		include dev::security
		include dev::xdebug
		notice("Running advanced xdebug config")
		dev::xdebug::config { 'default':
			profiler_output_name => 'xdebug.log'
		}
	}

	core::apache2::loadmodule{"rewrite": }

	core::apache2::loadmodule{"version": }

}
