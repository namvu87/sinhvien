<!DOCTYPE html>
<html lang="vi">
<head>
    <title>@yield('title', 'SHOP')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8" />
    <meta name="keywords" content="SHOP" />
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Custom-Files -->
    <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet" type="text/css" media="all" />
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" type="text/css" media="all" />
    <link rel="stylesheet" href="{{ asset('css/fontawesome-all.css') }}">
    <link href="{{ asset('css/popuo-box.css') }}" rel="stylesheet" type="text/css" media="all" />
    <link href="{{ asset('css/menu.css') }}" rel="stylesheet" type="text/css" media="all" />
    <link rel="stylesheet" href="{{ asset('css/about.css.css') }}">
    <link rel="stylesheet" href="{{ asset('css/similarproduct.css') }}">
    <link rel="stylesheet" href="{{ asset('css/flexslider.css') }}" type="text/css" media="screen" />
    
    <!-- web fonts -->
    <link href="//fonts.googleapis.com/css?family=Lato:100,100i,300,300i,400,400i,700,700i,900,900i&amp;subset=latin-ext" rel="stylesheet">
    <link href="//fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i&amp;subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese" rel="stylesheet">
    
    @stack('styles')
</head>
<body style="font-family: 'Roboto', sans-serif;">
    @include('components.topbar')
    @include('components.menu')
    
    <!-- Toast Notification Container -->
    <div aria-live="polite" aria-atomic="true" style="position: fixed; top: 20px; right: 20px; z-index: 9999;">
        <div id="toast-container" style="position: relative; min-height: 200px;"></div>
    </div>
    
    @yield('content')
    
    @include('components.footer')
    
    <!-- Javascript -->
    <script src="{{ asset('js/jquery-2.2.3.min.js') }}"></script>
    
    <!-- nav smooth scroll -->
    <script>
        $(document).ready(function () {
            $(".dropdown").hover(
                function () {
                    $('.dropdown-menu', this).stop(true, true).slideDown("fast");
                    $(this).toggleClass('open');
                },
                function () {
                    $('.dropdown-menu', this).stop(true, true).slideUp("fast");
                    $(this).toggleClass('open');
                }
            );
        });
    </script>
    
    <!-- popup modal -->
    <script src="{{ asset('js/jquery.magnific-popup.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('.popup-with-zoom-anim').magnificPopup({
                type: 'inline',
                fixedContentPos: false,
                fixedBgPos: true,
                overflowY: 'auto',
                closeBtnInside: true,
                preloader: false,
                midClick: true,
                removalDelay: 300,
                mainClass: 'my-mfp-zoom-in'
            });
        });
    </script>
    
    <!-- imagezoom -->
    <script src="{{ asset('js/imagezoom.js') }}"></script>
    
    <!-- flexslider -->
    <script src="{{ asset('js/jquery.flexslider.js') }}"></script>
    <script>
        $(window).load(function () {
            $('.flexslider').flexslider({
                animation: "slide",
                controlNav: "thumbnails"
            });
        });
    </script>
    
    <!-- scroll seller -->
    <script src="{{ asset('js/scroll.js') }}"></script>
    
    <!-- smoothscroll -->
    <script src="{{ asset('js/SmoothScroll.min.js') }}"></script>
    
    <!-- start-smooth-scrolling -->
    <script src="{{ asset('js/move-top.js') }}"></script>
    <script src="{{ asset('js/easing.js') }}"></script>
    <script>
        jQuery(document).ready(function ($) {
            $(".scroll").click(function (event) {
                event.preventDefault();
                $('html,body').animate({
                    scrollTop: $(this.hash).offset().top
                }, 1000);
            });
        });
    </script>
    
    <!-- smooth-scrolling-of-move-up -->
    <script>
        $(document).ready(function () {
            $().UItoTop({
                easingType: 'easeOutQuart'
            });
        });
    </script>
    
    <!-- for bootstrap working -->
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    
    <!-- Toast Notification Script -->
    <script>
        $(document).ready(function() {
            // Hiển thị toast từ session flash messages
            @if(session('success'))
                showToast('{{ session('success') }}', 'success');
            @endif
            
            @if(session('error'))
                showToast('{{ session('error') }}', 'error');
            @endif
            
            @if(session('info'))
                showToast('{{ session('info') }}', 'info');
            @endif
            
            // Tự động mở modal đăng nhập nếu cần
            @if(session('login_required'))
                // Hiển thị thông báo đặc biệt cho yêu cầu đăng nhập
                @if(session('message_type') == 'login_required')
                    showToast('{{ session('error') }}', 'error');
                @endif
                
                setTimeout(function() {
                    $('#loginModal').modal('show');
                }, 1000);
            @endif
            
            function showToast(message, type) {
                var bgColor = type === 'success' ? '#28a745' : type === 'error' ? '#dc3545' : '#17a2b8';
                var icon = type === 'success' ? '✓' : type === 'error' ? '⚠️' : 'ℹ';
                
                var toast = $('<div>')
                    .addClass('toast-notification')
                    .css({
                        'background-color': bgColor,
                        'color': 'white',
                        'padding': '15px 20px',
                        'border-radius': '8px',
                        'box-shadow': '0 4px 6px rgba(0,0,0,0.1)',
                        'margin-bottom': '10px',
                        'min-width': '300px',
                        'max-width': '400px',
                        'display': 'flex',
                        'align-items': 'center',
                        'animation': 'slideInRight 0.3s ease-out',
                        'position': 'relative'
                    })
                    .html(
                        '<span style="font-size: 20px; margin-right: 10px;">' + icon + '</span>' +
                        '<span style="flex: 1;">' + message + '</span>' +
                        '<button type="button" class="toast-close" style="background: none; border: none; color: white; font-size: 20px; cursor: pointer; margin-left: 10px; padding: 0 5px;">&times;</button>'
                    );
                
                $('#toast-container').append(toast);
                
                // Auto remove after 7 seconds (lâu hơn cho thông báo quan trọng)
                var autoRemoveTime = type === 'error' ? 7000 : 5000;
                setTimeout(function() {
                    toast.fadeOut(300, function() {
                        $(this).remove();
                    });
                }, autoRemoveTime);
                
                // Close button
                toast.find('.toast-close').click(function() {
                    toast.fadeOut(300, function() {
                        $(this).remove();
                    });
                });
            }
        });
    </script>
    
    <style>
        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        
        .toast-notification {
            animation: slideInRight 0.3s ease-out;
        }
    </style>
    
    @stack('scripts')
</body>
</html>

