
/* global momocountdown */
var triggerSlider = (options) => {
    var $block = jQuery('body').find( '#' + options.blockId  + ' .tec-slider-list');
    if ($block.length > 0) {
        if ($block.hasClass('slick-initialized')) {
            return;
        }
        var speed = $block.data('speed');
        var slidesToShow = $block.data('slides');
        var theme = $block.data('theme');
        var autoPlay = $block.data('auto');
        var color = $block.data('color');
        var id = $block.data('id');
        var count = $block.data('count');
        var dots = $block.data('dots');
        if ( count > 0) {
            $block.slick({
                dots: dots,
                infinite: true,
                speed: speed,
                slidesToShow: slidesToShow,
                adaptiveHeight: true,
                autoplay: autoPlay,
                responsive: [
                    {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: slidesToShow > 3 ? 3 : slidesToShow,
                        infinite: true,
                        dots: dots,
                        }
                    },
                    {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: slidesToShow > 2 ? 2 : slidesToShow,
                        infinite: true,
                        dots: dots,
                        }
                    },
                    {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        infinite: true,
                        dots: dots,
                        }
                    }
                ]
            });
            console.log('*** Running TecSlider Block****');
            fixHeightOfAll();
        }
        var $countdown = jQuery('body').find( '#' + options.blockId  + ' .contdown-data-holder');
        var countdownsJson = $countdown.data('countdown');

        if (countdownsJson === undefined || countdownsJson === null) {
            console.log('No countdowns found');
        } else if (typeof countdownsJson === 'object') {
            // It's already a JavaScript object
            var countdowns = countdownsJson;
            for (const countdown of countdownsJson) {
                enableAndUpdateCountdown( countdown.start, countdown.end, countdown.id, countdown.tmz );
            }
            console.log('Its already a JavaScript object');
        } else if (typeof countdownsJson === 'string') {
            // It's a JSON string, so parse it
            var countdowns = JSON.parse(countdownsJson);
            for (const countdown of countdowns) {
                enableAndUpdateCountdown( countdown.start, countdown.end, countdown.id, countdown.tmz );
            }
            console.log('Its json string');
        } else {
            console.log('Unknown data format');
        }
    }
};
function fixHeightOfAll() {
    jQuery('ul.tec-slider-list').each(function() {
        var $ul = jQuery(this);
        
        // Get the maximum height of .tec-sse-details elements within this ul
        var maxHeight = 0;
        $ul.find('.tec-sse-details').each(function() {
            var height = jQuery(this).outerHeight();
            if (height > maxHeight) {
                maxHeight = height;
            }
        });

        // Set the maximum height to all .tec-sse-details elements within this ul
        $ul.find('.tec-sse-details').css('height', maxHeight + 'px');

        $ul.find('.image-middle-top').each(function() {
            var height = jQuery(this).outerHeight();
            if (height > maxHeight) {
                maxHeight = height;
            }
        });
        $ul.find('.image-middle-top').css('height', maxHeight + 'px');

        $ul.find('.hover-flip-info').each(function() {
            var height = jQuery(this).outerHeight();
            if (height > maxHeight) {
                maxHeight = height;
            }
        });
        $ul.find('.hover-flip-info').css('height', maxHeight + 'px');
    });
}
// Function to calculate and display the countdown timer
function enableAndUpdateCountdown(eventStartDate, eventEndDate, countdownElementId, etmz = null) {
    let countdownInterval;
    function updateCountdown() {
        const eventTimezone = etmz !== null ? etmz : momocountdown.tmz;
        const timeZoneOptions = { timeZone: eventTimezone };
        const nowtz = new Date().toLocaleString('en-US', timeZoneOptions);
        const now = new Date(nowtz).getTime();
        const eventStartDateTime = new Date(eventStartDate).getTime();
        const eventEndDateTime = new Date(eventEndDate).getTime();
        const countdownElement = jQuery( '[data-id="' + countdownElementId + '"]').find('.tec-countdown');
        const info = countdownElement.find('.cd-info');
        const datetime = countdownElement.find('.cd-datetime');
        if (now < eventStartDateTime) {
            // Event has not started yet
            const timeLeft = eventStartDateTime - now;
            const days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
            const hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);
            info.html(momocountdown.start);
            var html = '';
            html += ('off' === momocountdown.rmday) ? `${days}<span class="dhms">${momocountdown.dhmsd}</span> ` : '';
            html += ('off' === momocountdown.rmhrs) ? `${hours}<span class="dhms">${momocountdown.dhmsh}</span> ` : '';
            html += ('off' === momocountdown.rmmin) ? `${minutes}<span class="dhms">${momocountdown.dhmsm}</span> ` : '';
            html += ('off' === momocountdown.rmsec) ? `${seconds}<span class="dhms">${momocountdown.dhmss}</span> ` : '';
            /* var html = `${days}<span class="dhms">${momocountdown.dhmsd}</span> ${hours}<span class="dhms">${momocountdown.dhmsh}</span> ${minutes}<span class="dhms">${momocountdown.dhmsm}</span> ${seconds}<span class="dhms">${momocountdown.dhmss}</span>`; */
            datetime.html(html);
        } else if (now < eventEndDateTime) {
            // Event has started and is still running
            const timeLeft = eventEndDateTime - now;
            const days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
            const hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

            info.html(momocountdown.endsin);
            var html = '';
            html += ('off' === momocountdown.rmday) ? `${days}<span class="dhms">${momocountdown.dhmsd}</span> ` : '';
            html += ('off' === momocountdown.rmhrs) ? `${hours}<span class="dhms">${momocountdown.dhmsh}</span> ` : '';
            html += ('off' === momocountdown.rmmin) ? `${minutes}<span class="dhms">${momocountdown.dhmsm}</span> ` : '';
            html += ('off' === momocountdown.rmsec) ? `${seconds}<span class="dhms">${momocountdown.dhmss}</span> ` : '';
            /* datetime.html(`${days}<span class="dhms">${momocountdown.dhmsd}</span> ${hours}<span class="dhms">${momocountdown.dhmsh}</span> ${minutes}<span class="dhms">${momocountdown.dhmsm}</span> ${seconds}<span class="dhms">${momocountdown.dhmss}</span>`); */
            datetime.html(html);
        } else {
            // Event has ended
            info.html(momocountdown.end);
            clearInterval(countdownInterval); // Stop updating the countdown
        }
    }

    // Initial call to update the countdown
    updateCountdown();

    // Update the countdown every second
    countdownInterval = setInterval(updateCountdown, 1000);
    console.log('***Countdown Timer Started***');
    // Return a function to clear the interval when needed
    return function () {
        clearInterval(countdownInterval);
    };
}