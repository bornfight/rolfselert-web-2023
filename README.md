# Install

Installed on system with.

```
Node v12.22.12
Grunt v1.4.3
Ruby v2.6.10p210
Gem v3.0.3.1
```

Go to `wp-content/themes/reo` dir and execute commands in order.

```
npm install -g grunt
sudo gem install sass
npm install
grunt 
```

# Develop

To run watcher execute command.

```
grunt
```

This is output.

```
➜  reo git:(master) ✗ grunt
Running "watch" task
Waiting...
>> File "scss/site.scss" changed.
Running "sass:dev" (sass) task

Running "cssmin:combine" (cssmin) task
File css/site.min.css created: 62.71 kB → 43.68 kB
File css/critical.min.css created: 9.88 kB → 7.4 kB

Done, without errors.
Completed in 2.017s at Wed Apr 05 2023 10:57:16 GMT+0200 (Central European Summer Time) - Waiting...
```
