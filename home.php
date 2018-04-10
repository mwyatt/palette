<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link href="//fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800" rel="stylesheet" rel="preload">
    <meta charset="UTF-8">
    <title>Colors</title>
    <link rel="stylesheet" type="text/css" href="bootstrap.min.css">
    <style type="text/css">
        .color-wrap {
            overflow: hidden;
            height: 120px;
            float: left;
            padding: 8px;
            width: 64px;
        }

        .color {
            height: 35px;
            color: #fff;
            padding: 10px;
            border-radius: 3px;
        }

        * {
            font-size: 12px;
            font-family: 'Open Sans';
        }

        html {
            color: hsla(0, 0%, 50%, 1);
        }

        body {
            padding-bottom: 71px;
        }

        .hex-copy {
            position: absolute;
            top: -10em;
            left: -10em;
        }

        .color-wrap.selected {
            background-color: #eee;
        }

        .color-name {margin-top: 9px;}

        .mix-palette {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    padding: 40px;
    text-align: center;
    font-size: 18px;
    color: #fff;
        }

        .color-hex {
            font-size: 9px;
            display: none;
        }

        .color-hex:hover {
    background: white;
    color: #666;
    border-radius: 3px;
    opacity: .5;
    cursor: pointer;
        }
    </style>
</head>
<body>
    <input type="text" class="js-hex-copy hex-copy" value="#234892034">
    <div class="clearfix">
        

<?php foreach ($colors as $color): ?>
    
    <div class="color-wrap js-color-wrap">
        <div class="color" style="background-color: #<?php echo $color['hex'] ?>;">
            <span class="color-hex js-color-hex" title="Copy to clipboard"><?php echo $color['hex'] ?></span>
        </div>
        <p class="color-name js-color-name"><?php echo $color['name'] ?></p>
        <span class="color-mix-count js-color-mix-count">0</span>
    </div>

<?php endforeach ?>

    </div>
    <div class="js-mix-palette mix-palette">
        Reset
    </div>
    <div class="js-color-wheel"></div>
    <button class="btn btn-primary js-btn-try invisible">Try</button>
    <script type="text/javascript" src="jquery-3.3.1.min.js"></script>
    <script type="text/javascript">
        function getHexs() {
            var hexs = []
            for (var i = 0; i < $('.selected').length; i++) {
                hexs.push($($('.selected')[i]).find('.js-color-hex').html())
            }
            return hexs
        }
        $(document).ready(function() {
            $('.js-color-hex').on('click', function() {
                $('.js-hex-copy').val($(this).html())
                $('.js-hex-copy')[0].select()
                document.execCommand("Copy");
                console.log('Copied ' + $(this).html())
            });
            // $('.js-color-name').on('click', function() {
            //     $(this).closest('.js-color-wrap').toggleClass('selected');
            //     if ($('.selected').length) {
            //         $('.js-btn-try').removeClass('invisible')
            //     } else {
            //         $('.js-btn-try').addClass('invisible')
            //     }
            // });
            $('.js-btn-try').on('click', function() {
                var hexs = getHexs()
                window.open('http://trycolors.com/?try=1&' + hexs.join('=0&') + '=0', '_blank');
            });
            $('.js-mix-palette').on('click', function() {
                $('.js-color-wrap').removeClass('selected');
                doColorLookup()
            })
            $('.js-color-wrap').on('click', function() {
                $(this).addClass('selected');
                var $mixCount = $(this).find('.js-color-mix-count')
                var currCount = parseInt($mixCount.html())
                currCount ++
                $mixCount.html(currCount)
                doColorLookup()
            });
        })

        function doColorLookup() {
            var hexs = {}
            for (var i = 0; i < $('.js-color-wrap').length; i++) {
                hexs[$($('.js-color-wrap')[i]).find('.js-color-hex').html()] = $($('.js-color-wrap')[i]).find('.js-color-mix-count').html()
            }
            $.ajax({
                url: 'mix.php',
                type: 'post',
                dataType: 'json',
                data: {
                    key: 'R56bvF8KD7y',
                    type: 'mix',
                    input: JSON.stringify(hexs),
                },
                success: function(response) {
                    $('.js-mix-palette').css('background-color', response)
                },
                error: function(response, two, three, four) {
                    
                }
            })
        }
    </script>
</body>
</html>
