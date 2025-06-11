FROM akilli/php

LABEL maintainer="Ayhan Akilli"

#
# Setup
#
COPY . /app/
COPY dist-upgrade /usr/local/bin/dist-upgrade

#
# Onbuild
#
ONBUILD COPY . /data/ext/
ONBUILD RUN su-exec app php /app/preload.php
ONBUILD RUN dist-upgrade
