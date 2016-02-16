# -*- mode: ruby -*-
# vi: set ft=ruby :

$create_swap = <<SH
#!/bin/sh

# size of swapfile in megabytes
swapsize=2048

# does the swap file already exist?
grep -q "swapfile" /etc/fstab

# if not then create it
if [ $? -ne 0 ]; then
  echo 'swapfile not found. Adding swapfile.'
  fallocate -l ${swapsize}M /swapfile
  chmod 600 /swapfile
  mkswap /swapfile
  swapon /swapfile
  echo '/swapfile none swap defaults 0 0' >> /etc/fstab
else
  echo 'swapfile found. No changes made.'
fi

# output results to terminal
df -h
cat /proc/swaps
cat /proc/meminfo | grep Swap
SH

Vagrant.configure(2) do |config|

  config.vm.box = "ubuntu/trusty64"
  config.vm.network :private_network, ip: "192.168.255.60"
  config.vm.synced_folder ".", "/vagrant", type: "nfs"
  config.vm.network :forwarded_port, guest: 22, host: 2205, id: "ssh", auto_correct: true

  config.vm.provision "shell", inline: $create_swap

    config.vm.provision "puppet" do |puppet|
      puppet.manifests_path = "manifests"
      puppet.manifest_file  = "site.pp"
    end

    # CPU and Memory
    config.vm.provider "virtualbox" do |v|
        host = RbConfig::CONFIG['host_os']

          # Give VM 1/4 system memory & access to all cpu cores on the host
          if host =~ /darwin/
            cpus = `sysctl -n hw.ncpu`.to_i
            # sysctl returns Bytes and we need to convert to MB
            mem = `sysctl -n hw.memsize`.to_i / 1024 / 1024 / 4
          elsif host =~ /linux/
            cpus = `nproc`.to_i
            # meminfo shows KB and we need to convert to MB
            mem = `grep 'MemTotal' /proc/meminfo | sed -e 's/MemTotal://' -e 's/ kB//'`.to_i / 1024 / 4
          else # sorry Windows folks, I can't help you
            cpus = 2
            mem = 1024
          end

          if mem <= 1024
            mem = 512
          end

          v.memory = mem
          v.cpus = cpus
    end
end
