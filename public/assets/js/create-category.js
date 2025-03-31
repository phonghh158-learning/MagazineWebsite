function showFormButton() {
    document.getElementById('form-button').style.display = 'flex';
}

function loadIcon() {
    let iconClass1 = ["bx-sticker", "bx-shield-quarter", "bx-upside-down", "bx-laugh", "bx-meh-blank", "bx-happy-beaming", "bx-shocked", "bx-sleepy", "bx-confused", "bx-wink-smile", "bx-dizzy", "bx-happy-heart-eyes", "bx-angry", "bx-smile", "bx-tired", "bx-cool", "bx-happy-alt", "bx-wink-tongue", "bx-meh-alt", "bx-food-menu", "bx-food-tag", "bx-female-sign", "bx-male-sign", "bx-female", "bx-male", "bx-clinic", "bx-health", "bx-shekel", "bx-yen", "bx-won", "bx-pound", "bx-euro", "bx-rupee", "bx-ruble", "bx-lira", "bx-bitcoin", "bx-tone", "bx-bolt-circle", "bx-cake", "bx-spa", "bx-dish", "bx-fridge", "bx-image-add", "bx-image-alt", "bx-space-bar", "bx-alarm-add", "bx-archive-out", "bx-archive-in", "bx-add-to-queue", "bx-border-radius", "bx-check-shield", "bx-label", "bx-file-find", "bx-face", "bx-extension", "bx-exit", "bx-conversation", "bx-sort-z-a", "bx-sort-a-z", "bx-printer", "bx-radio", "bx-customize", "bx-brush-alt", "bx-briefcase-alt-2", "bx-time-five", "bx-pie-chart-alt-2", "bx-gas-pump", "bx-mobile-vibration", "bx-mobile-landscape", "bx-dialpad-alt", "bx-filter-alt", "bx-wifi-off", "bx-credit-card-alt", "bx-band-aid", "bx-hive", "bx-map-pin", "bx-line-chart", "bx-receipt", "bx-purchase-tag-alt", "bx-basket", "bx-palette", "bx-no-entry", "bx-message-alt-dots", "bx-message-alt", "bx-check-square", "bx-doughnut-chart", "bx-building-house", "bx-accessibility", "bx-user-voice", "bx-cuboid", "bx-cube-alt", "bx-polygon", "bx-square-rounded", "bx-square", "bx-error-alt", "bx-shield-alt-2", "bx-paint-roll", "bx-droplet", "bx-street-view", "bx-plus-medical", "bx-search-alt-2", "bx-bowling-ball", "bx-dna", "bx-cycling", "bx-lock-open-alt", "bx-lock-alt", "bx-cylinder", "bx-pyramid", "bx-comment-dots", "bx-comment", "bx-landscape", "bx-book-open", "bx-transfer-alt", "bx-copy-alt", "bx-run", "bx-user-pin", "bx-dollar", "bx-directions", "bx-desktop", "bx-data", "bx-compass", "bx-crosshair", "bx-terminal", "bx-cloud", "bx-cloud-upload", "bx-cloud-download", "bx-bookmark-plus", "bx-bookmark-minus", "bx-book", "bx-book-bookmark", "bx-basketball", "bx-bar-chart", "bx-bar-chart-square", "bx-bar-chart-alt", "bx-at", "bx-archive", "bx-zoom-out", "bx-zoom-in", "bx-x-circle", "bx-video", "bx-vertical-center", "bx-trending-up", "bx-trending-down", "bx-time", "bx-sync", "bx-stopwatch", "bx-stop", "bx-stop-circle", "bx-skip-previous", "bx-skip-next", "bx-show", "bx-search", "bx-rss", "bx-reset", "bx-rewind", "bx-rectangle", "bx-question-mark", "bx-play", "bx-pause"];
    let iconClass2 = ["bx-show-alt", "bx-caret-down", "bx-caret-right", "bx-caret-up", "bx-caret-left", "bx-calendar-event", "bx-magnet", "bx-rewind-circle", "bx-card", "bx-help-circle", "bx-test-tube", "bx-note", "bx-sort-down", "bx-sort-up", "bx-id-card", "bx-badge", "bx-grid-small", "bx-grid-vertical", "bx-grid-horizontal", "bx-move-vertical", "bx-move-horizontal", "bx-stats", "bx-equalizer", "bx-disc", "bx-analyse", "bx-search-alt", "bx-dollar-circle", "bx-football", "bx-ball", "bx-circle", "bx-transfer", "bx-fingerprint", "bx-font-color", "bx-highlight", "bx-file-blank", "bx-strikethrough", "bx-photo-album", "bx-code-block", "bx-font-size", "bx-handicap", "bx-dialpad", "bx-wind", "bx-water", "bx-swim", "bx-restaurant", "bx-box", "bx-menu-alt-right", "bx-menu-alt-left", "bx-video-plus", "bx-list-ol", "bx-planet", "bx-hotel", "bx-movie", "bx-taxi", "bx-train", "bx-bath", "bx-bed", "bx-area", "bx-bot", "bx-dumbbell", "bx-check-double", "bx-bus", "bx-check-circle", "bx-rocket", "bx-certification", "bx-slider-alt", "bx-sad", "bx-meh", "bx-happy", "bx-cart-alt", "bx-car", "bx-loader-alt", "bx-loader-circle", "bx-wrench", "bx-alarm-off", "bx-layout", "bx-dock-left", "bx-dock-top", "bx-dock-right", "bx-dock-bottom", "bx-dock-bottom", "bx-world", "bx-selection", "bx-paper-plane", "bx-slider", "bx-loader", "bx-chalkboard", "bx-trash-alt", "bx-grid-alt", "bx-command", "bx-window-close", "bx-notification-off", "bx-plug", "bx-infinite", "bx-carousel", "bx-hourglass", "bx-briefcase-alt", "bx-wallet", "bx-station", "bx-collection", "bx-tv", "bx-closet", "bx-paperclip", "bx-expand", "bx-pen", "bx-purchase-tag", "bx-images", "bx-pie-chart-alt", "bx-news", "bx-downvote", "bx-upvote", "bx-globe-alt", "bx-store", "bx-hdd", "bx-skip-previous-circle", "bx-skip-next-circle", "bx-chip", "bx-cast", "bx-body", "bx-phone-outgoing", "bx-phone-incoming", "bx-collapse", "bx-rename", "bx-rotate-right", "bx-horizontal-center", "bx-ruler", "bx-import", "bx-calendar-alt", "bx-battery", "bx-server", "bx-task", "bx-folder-open", "bx-film", "bx-aperture", "bx-phone-call", "bx-undo", "bx-timer", "bx-support", "bx-subdirectory-right", "bx-revision", "bx-repost", "bx-reply", "bx-reply-all", "bx-redo", "bx-radar", "bx-poll", "bx-list-check", "bx-like", "bx-joystick-alt", "bx-chart", "bx-calendar", "bx-calendar-x", "bx-calendar-minus", "bx-calendar-check", "bx-calendar-plus", "bx-buoy", "bx-bulb", "bx-bluetooth", "bx-bug", "bx-building", "bx-broadcast", "bx-briefcase", "bx-block"];
    let iconClass3 = ["bx-history", "bx-flag", "bx-first-aid", "bx-export", "bx-dislike", "bx-crown", "bx-barcode", "bx-underline", "bx-trophy", "bx-trash", "bx-text", "bx-sun", "bx-star", "bx-sort", "bx-shuffle", "bx-shopping-bag", "bx-shield", "bx-shield-alt", "bx-share", "bx-share-alt", "bx-select-multiple", "bx-screenshot", "bx-save", "bx-pulse", "bx-power-off", "bx-plus", "bx-pin", "bx-pencil", "bx-pin", "bx-pencil", "bx-paste", "bx-paragraph", "bx-package", "bx-notification", "bx-music", "bx-move", "bx-mouse", "bx-microphone-off", "bx-log-out", "bx-log-in", "bx-link-external", "bx-joystick", "bx-italic", "bx-home-alt", "bx-heading", "bx-hash", "bx-group", "bx-font", "bx-filter", "bx-file", "bx-edit", "bx-diamond", "bx-detail", "bx-cut", "bx-cube", "bx-crop", "bx-credit-card", "bx-columns", "bx-cloud-snow", "bx-cloud-rain", "bx-cloud-lightning", "bx-cloud-light-rain", "bx-cloud-drizzle", "bx-check", "bx-cart", "bx-calculator", "bx-bold", "bx-award", "bx-anchor", "bx-album", "bx-adjust", "bx-table", "bx-duplicate", "bx-windows", "bx-window", "bx-window-open", "bx-wifi", "bx-voicemail", "bx-video-off", "bx-usb", "bx-upload", "bx-alarm", "bx-tennis-ball", "bx-target-lock", "bx-tag", "bx-tab", "bx-spreadsheet", "bx-sitemap", "bx-sidebar", "bx-send", "bx-pie-chart", "bx-phone", "bx-navigation", "bx-mobile", "bx-mobile-alt", "bx-message", "bx-message-rounded", "bx-map", "bx-map-alt", "bx-lock", "bx-lock-open", "bx-list-minus", "bx-list-ul", "bx-list-plus", "bx-link", "bx-link-alt", "bx-layer", "bx-laptop", "bx-home", "bx-heart", "bx-headphone", "bx-devices", "bx-globe", "bx-gift", "bx-envelope", "bx-download", "bx-dots-vertical", "bx-dots-vertical-rounded", "bx-dots-horizontal", "bx-dots-horizontal-rounded", "bx-moon", "bx-microphone", "bx-last-page", "bx-key", "bx-info-circle", "bx-image", "bx-hide", "bx-fullscreen", "bx-folder", "bx-folder-plus", "bx-folder-minus", "bx-first-page", "bx-fast-forward", "bx-fast-forward-circle", "bx-exit-fullscreen", "bx-error", "bx-error-circle", "bx-copyright", "bx-copy", "bx-coffee", "bx-code", "bx-code-curly", "bx-clipboard", "bx-captions", "bx-camera", "bx-camera-off", "bx-bullseye", "bx-bookmarks", "bx-bookmark", "bx-bell", "bx-bell-plus", "bx-bell-off", "bx-bell-minus"];

    let groupIcon = document.getElementById('group-icon');
    groupIcon.style.height = '240px';

    for (let i = 0; i < iconClass1.length; i++) {
        let lbl = document.createElement('label');
        lbl.classList.add('input-item');
        lbl.setAttribute('for', 'icon');

        let input = document.createElement('input');
        input.setAttribute('type', 'radio');
        input.setAttribute('name', 'icon');
        input.setAttribute('id', 'icon');
        input.setAttribute('value', "<i class='bx " + iconClass1[i] + "'></i>");

        let icon = document.createElement('i');
        icon.classList.add('bx');
        icon.classList.add(iconClass1[i]);
    
        lbl.appendChild(input);
        lbl.appendChild(icon);
        groupIcon.appendChild(lbl);
    }

    for (let i = 0; i < iconClass2.length; i++) {
        let lbl = document.createElement('label');
        lbl.classList.add('input-item');
        lbl.setAttribute('for', 'icon');

        let input = document.createElement('input');
        input.setAttribute('type', 'radio');
        input.setAttribute('name', 'icon');
        input.setAttribute('id', 'icon');
        input.setAttribute('value', "<i class='bx " + iconClass2[i] + "'></i>");

        let icon = document.createElement('i');
        icon.classList.add('bx');
        icon.classList.add(iconClass2[i]);
    
        lbl.appendChild(input);
        lbl.appendChild(icon);
        groupIcon.appendChild(lbl);
    }

    for (let i = 0; i < iconClass3.length; i++) {
        let lbl = document.createElement('label');
        lbl.classList.add('input-item');
        lbl.setAttribute('for', 'icon');

        let input = document.createElement('input');
        input.setAttribute('type', 'radio');
        input.setAttribute('name', 'icon');
        input.setAttribute('id', 'icon');
        input.setAttribute('value', "<i class='bx " + iconClass3[i] + "'></i>");

        let icon = document.createElement('i');
        icon.classList.add('bx');
        icon.classList.add(iconClass3[i]);
    
        lbl.appendChild(input);
        lbl.appendChild(icon);
        groupIcon.appendChild(lbl);
    }
}

showFormButton();

loadIcon();
