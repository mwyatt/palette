<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link href="//fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800" rel="stylesheet" rel="preload">
    <meta charset="UTF-8">
    <title>Colors</title>
    <link rel="stylesheet" type="text/css" href="bootstrap.min.css">
    <style type="text/css">
        .mix-palette-reset {
            border-right: 1px solid #fff;
        }

        .color-label {
            position: relative;
            z-index: 1;
        }

        .group-heading {
            font-size: 14px;
            font-weight: 600;
            text-align: center;
            padding: 11px;
            border-bottom: 1px dotted #ccc;
            background-color: #eee;
        }

        .copy-recipe {
            float: right;
        }

        .copy-recipe, .mix-palette-reset {
            padding: 40px;
            width: 50%;
            font-size: 20px;
            line-height: 1;
        }

        .color-hsl {
            color: #fff;
                font-size: 9px;
                position: absolute;
                bottom: 0;
                left: 0;
                right: 0;
                text-align: center;
                padding: 2px;
                font-family: arial;
                letter-spacing: 0.6px;
        }

        .color-wrap {
            overflow: hidden;
            height: 100px;
            float: left;
            padding: 10px;
            width: 68px;
        }

        .copy-recipe:active,
        .color-wrap:active {
            background:  #ccc;
        }

        .color {
            position: relative;
            color: #fff;
            padding: 10px;
            border-radius: 3px;
        }

        * {
            font-size: 14px;
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

        .color-name {
            word-wrap: break-word;
            word-break: break-all;
            margin-top: 9px;
            font-size: 12px;
        }

        .color-mix-count {
            text-align: center;
            font-size: 16px;
            font-weight: 600;
            line-height: 18px;
            height: 18px;
        }

        .mix-palette {
            z-index: 2;
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 18px;
            color: #fff;
            background-color: #eee;
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

        .wheel-container {
            z-index: 3;
            position: absolute;
            top: 0;
            left: 0;
            overflow: hidden;
            right: 0;
            padding: 50% 60px;
            background: rgba(255,255,255,0.6);
            bottom: 0;
        }
    </style>
</head>
<body>
    <div class="wheel-container js-wheel-container d-none"><?php include('wheel.svg') ?></div>
    <input type="text" class="js-hex-copy hex-copy" value="#234892034">
    <div class="p-2 mb-2 border-bottom text-secondary">
        <span class="btn btn-sm btn-secondary js-open-wheel float-right">Wheel</span>
        <label class="form-control-label">Order</label>
        - <a class="" href="?order=h-grouped">Grouped</a>
        - <a class="" href="?order=hsl&order-key=0">Hue</a>
        - <a class="" href="?order=hsl&order-key=1">Saturation</a>
        - <a class="" href="?order=hsl&order-key=2">Luminance</a>
    </div>
</div>
<div class="clearfix">

    <?php if (empty($colorsGrouped)): ?>
        <?php foreach ($colors as $color): ?>
            <?php include('color.php') ?>
        <?php endforeach ?>
    <?php else: ?>
        <?php foreach ($colorsGrouped as $group): ?>

            <div class="clearfix"></div>
            <div class="group-heading"><?php echo $group['name'] ?> (<?php echo $group['range'][0] ?> - <?php echo $group['range'][1] ?>)</div>

            <?php foreach ($group['colors'] as $color): ?>
                <?php include('color.php') ?>
            <?php endforeach ?>
        <?php endforeach ?>
    <?php endif ?>


</div>
<div class="js-mix-palette mix-palette">
    <div class="js-copy-recipe copy-recipe">Copy Recipe</div>
    <div class="js-mix-palette-reset mix-palette-reset">Reset</div>
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
            $('.js-mix-palette-reset').on('click', function() {
                $('.js-color-wrap').removeClass('selected');
                $('.js-color-mix-count').html('');
                $('.js-mix-palette').css('background-color', '')
                doColorLookup()
            })
            $('.js-open-wheel').on('click', function() {
                $('.js-wheel-container').removeClass('d-none')
            })
            $('.js-wheel-container').on('click', function() {
                $('.js-wheel-container').addClass('d-none')
            })
            $('.js-copy-recipe').on('click', function() {
                var formulas = []
                for (var i = 0; i < $('.js-color-wrap.selected').length; i++) {
                    formulas.push($($('.js-color-wrap.selected')[i]).find('.js-color-mix-count').html() + ' × ' + $($('.js-color-wrap.selected')[i]).find('.js-color-name').html())
                }
                $('.js-hex-copy').val(formulas.join(', '))
                $('.js-hex-copy')[0].select()
                document.execCommand("Copy");
            })
            $('.js-color-wrap').on('click', function() {
                $(this).addClass('selected');
                var $mixCount = $(this).find('.js-color-mix-count')
                var currCount = parseInt($mixCount.html())
                currCount = currCount ? currCount : 0
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
