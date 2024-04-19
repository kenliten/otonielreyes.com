# Home Labbing Log 1
April 18, 2024

This is the start of my journey in home labbing. I want to dive into server/system administration and networking, so I'm going to start with the hardware I have available right now. A friend of mine gave me an old pc with an Intel Core i5 670, 8gb DDR3 ram and 160gb HDD, that's going to be my first home server in this journey.

Today, to start my journey, I took 45 minutes to deeply clean, re-apply thermical compound and put back every part together. After a deep cleaning process, I started by downloading an operating system to install on my new cheap as hell home server.
Initially I was thinking installing debian, but soon I realised that I'm already running debian in my main workstation so it would be too easy to do my normal setup in an OS I'm very comfortable with, so, to make it more interesting I have decided to use [Fedora Server](https://fedoraproject.org/server/) in the mentioned home server.

__Why Fedora?__ you ask. And the answer have three points:

1) Not in the confort zone: when it comes to Operating Systems, almost always I use a Debian or Ubuntu based OS, I really like Linux Mint, Kubuntu, Elementary (not too much now thanks to the default, almost mandatory snap) or even directly Debian, the others are OpenSUSE, Arch, Manjaro and Solus. As you can see, most use the deb+apt package management, and only one (OpenSUSE) use RPMs, so I want to become expert in an rpm based system, I'm sure it will be helpful some day.

2) Target & usecase: another reason is that, is an operating system design specifically for servers, so, maybe (i guess) it'll be more accurate to my particular usecase.

3) Networking oportunity: I've never took the time to get involved in Fedora community, so maybe this time I meet new people, new friends while contribute to the community in every way I can.

## Log & Outcomes

- Setup a phisical home server
- Installed Fedora Server OS in the home server
- Installed all components for the LAMP stack: Apache (httpd), MySQL (mariadb-server), PHP
- Created a self-signed SSL certificate
- Installed and configured my self-signed SSL certificate in apache
- Served my website locally
- Exposed apache port to the network

## Learning

- Apache's package is httpd (the real name of the web server project) in Fedora, in debian and ubuntu is apache2.
- Just discovered the useful pre-installed server administration web panel running in port 9090, didn't even spected it.
- `firewall-cmd`, the program for controlling the firewall in Fedora Server, awesome and pretty simple/easy-to-use.
- [Fedora Documentation Page](https://docs.fedoraproject.org/en-US/fedora-server/) is the go-to place for any doubt or general/normal task you want to know about.