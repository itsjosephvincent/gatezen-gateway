#!/bin/sh
if ps aux | grep syncusers | grep -v grep ; then
    continue
else
    cd "$1" && php artisan queue:work 'jobs' --queue=syncusers --daemon --delay=30 & >> "$1/queues/queues.log" 2>&1
fi

#!/bin/sh
if ps aux | grep syncshares | grep -v grep ; then
    continue
else
    cd "$1" && php artisan queue:work 'jobs' --queue=syncshares --daemon --delay=30 & >> "$1/queues/queues.log" 2>&1
fi
