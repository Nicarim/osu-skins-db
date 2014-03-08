<head>

    <link rel="stylesheet" href="/css/bootstrap.css" />
    <link rel="stylesheet" href="/css/bootstrap-theme.css" />
    <link rel="stylesheet" href="/dropzone/basic.css" />
    <link rel="stylesheet" href="/fancybox/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" />
    <link rel="stylesheet" href="/css/main.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="/js/jquery-2.0.3.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script src="/dropzone/dropzone.js"></script>
    <script src="/js/kinetic-v5.0.1.min.js"></script>
    <script type="text/javascript" src="/fancybox/jquery.fancybox.pack.js?v=2.1.5"></script>
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-21965013-5', 'hiroto.eu');
        ga('send', 'pageview');
    </script>
    <script src="/js/main.js"></script>
</head>
@include('navbar')
<body style="padding-top: 70px;">
@yield ('content')
</body>