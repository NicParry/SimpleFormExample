exec {"apt-get update":
  path => "/usr/bin",
}

file { "/etc/hostname":
  ensure  => present,
  owner   => root,
  group   => root,
  mode    => '0644',
  content => "l-simpleform.com\n",
  notify  => Exec["set-hostname"]
}

exec { "set-hostname":
  command => '/bin/hostname -F /etc/hostname',
  unless  => "/usr/bin/test `hostname` = `/bin/cat /etc/hostname`"
}

package {"apache2":
  ensure => present,
  require => Exec["apt-get update"],
}

service { "apache2":
  ensure => "running",
  require => Package["apache2"]
}

package { ["php5-common", "libapache2-mod-php5", "php5-cli", "git", "php5-xdebug"]:
  ensure => installed,
  notify => Service["apache2"],
  require => [Exec["apt-get update"], Package['apache2']],
}

exec { "/usr/sbin/a2enmod rewrite" :
  unless => "/bin/readlink -e /etc/apache2/mods-enabled/rewrite.load",
  notify => Service[apache2],
  require => Package['apache2']
}

file {"/var/www":
  ensure => "link",
  target => "/vagrant",
  require => Package["apache2"],
  notify => Service["apache2"],
  replace => yes,
  force => true,
}

exec { "ApacheUserChange" :
  command => "/bin/sed -i 's/APACHE_RUN_USER=www-data/APACHE_RUN_USER=vagrant/' /etc/apache2/envvars",
  onlyif  => "/bin/grep -c 'APACHE_RUN_USER=www-data' /etc/apache2/envvars",
  require => Package["apache2"],
  notify  => Service["apache2"],
}

exec { "ApacheGroupChange" :
  command => "/bin/sed -i 's/APACHE_RUN_GROUP=www-data/APACHE_RUN_GROUP=vagrant/' /etc/apache2/envvars",
  onlyif  => "/bin/grep -c 'APACHE_RUN_GROUP=www-data' /etc/apache2/envvars",
  require => Package["apache2"],
  notify  => Service["apache2"],
}

exec { "apache_lockfile_permissions" :
  command => "/bin/chown -R vagrant:www-data /var/lock/apache2",
  require => Package["apache2"],
  notify  => Service["apache2"],
}

file { "/etc/apache2/sites-enabled/default.conf":
  ensure => "link",
  target => "/vagrant/manifests/assets/vhost.conf",
  require => Package["apache2"],
  notify => Service["apache2"],
  replace => yes,
  force => true,
}

file {"/var/www/html":
  ensure => "link",
  target => "/vagrant/web",
  require => Package["apache2"],
  notify => Service["apache2"],
  replace => yes,
  force => true,
}

package { "curl":
  ensure => installed,
}

exec { 'install composer':
  command => '/usr/bin/curl -sS https://getcomposer.org/installer | HOME=/home/vagrant php && sudo mv composer.phar /usr/local/bin/composer',
  require => Package['curl'],
}
