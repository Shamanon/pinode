# pinode
Use a raspberry pi to control relays, play pandora and  music streams from a web browser.

This code is designed as a base for a Raspberry Pi based smart home.

pinode provides (or plans to provide) the following:

	GPIO CONTROL - PHP class to control GPIO ports. Bash script to initialize GPIO ports on boot, call GPIOinit from rc.local

	MPLAYER PLAYBACK - Use mplayer to play Icecast and Internet Radio streams

	PANDORA PLAYBACK - Use pianobar to stream pandora via rPi. Includes the script "pando" to start pianobar. Pando downloads
	current TLS fingerprint, updates local config file then starts pianobar. This is a bit of a hack so that you can install
	pianobar using apt or apt-get and don't need to go through the process of installing from source.
	
	SUNRISE/SUNSET FUNCTIONS - I hope to avoid using suncron in the future and will write a systemd service that will check
	suntimes and control relays accordingly.

	INTERNODE COMMUNICATION - One pi will be a master and the rest will be nodes. Ideally only the master will need a LAMP 
	stack and all interPI communication will happen over SSH
