function init (text1, text2) {
    $(document).ready(function(){
        let limit = 6;
        let start = 0;
        let action = 'inactive';
        function load_country_data(limit, start)
        {
            $.ajax({
                method: "POST",
                data: {limit: limit, start: start},
                cache: false,
                success: function (data) {
                    $('#load_data').append(data);
                    if ($("<div>" + data + "</div>").find(".listing__item").length === 0) {
                        if(start === 0) {
                            $('#load_data_message').html(text1);
                            action = 'active';
                        } else {
                            $('#load_data_message').html(text2);
                            action = 'active';
                        }
                    }
                    else {
                        $('#load_data_message').html("<center><img alt='loading' width='100' src='https://media.giphy.com/media/3oEjI6SIIHBdRxXI40/giphy.gif' /></center>");
                        action = "inactive";
                    }
                },
                error: function (data) {
                    alert('error');
                },
            });
        }
        if(action === 'inactive') {
            action = 'active';
            load_country_data(limit, start);
        }

        let listing = $('.listing');
        let loadData = $("#load_data");

        $(".listing").scroll(function(){
            if((listing.scrollTop() + listing.height() > loadData.height() - 100 && action === 'inactive') )
            {
                action = 'active';
                start = start + limit;
                setTimeout(function(){
                    load_country_data(limit, start);
                }, 800);
            }
        });

        if(!loadData.height())
        {
            action = 'active';
            start = start + limit;
            setTimeout(function(){
                load_country_data(limit, start);
            }, 1200);
        }
    });
}

