<!DOCTYPE html>
<html lang="en">


@php
    $style = request()->query('style');
    $style = $style == 1 ? 'bg2' : 'bg1';

    $imgUrl = asset('assets/images/mask/v.png');
    if($style == 'bg2') {
        $imgUrl = asset('assets/images/mask/u.png');
    }
@endphp


<head>
    <base href="/">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="CoreData Sdn. Bhd. HelpDesk">
    <title>{{ config('app.name', 'HelpDesk') }}</title>
    <link rel="shortcut icon" href="/images/coredata-logo-only.png">
    <link rel="stylesheet" href="/assets/css/style.css?v1.1.2">
    @yield('css')

    <style>
        /* Ensure particles container covers the full page */
        #particles-js {
            position: absolute;
            width: 100%;
            height: 100%;
            z-index: -1; /* Ensures particles stay behind other content */
            top: 0;
            left: 0;
            background-color: rgba(223, 215, 216, 0.29); /* Light background color if needed */
            background-image: url("{{ $imgUrl }}");
            background-size: cover;
            background-position: center;
        }

        /* Disable pointer events on specific elements */
        .card-auth,
        .card-body.is-theme {
            pointer-events: auto; /* Allow interaction with these containers */
            z-index: 10; /* Ensure these elements are above the canvas */
        }

        /* Ensure other elements pass through events to the canvas */
        .nk-wrap,
        .nk-app-root {
            pointer-events: none; /* Pass events to the canvas */
        }

        /* to allow "text welcome" */
        .d-none .card-body {
            pointer-events: none !important; /* Ensure hidden elements do not capture events */
        }

        canvas {
            pointer-events: auto; /* Ensure canvas captures pointer events */
        }

        @media only screen and (max-width: 768px) {
            .login-form {
                opacity: 0.95;
            }
        }
    </style>

    @if($style == 'bg2')
        <style>
            @media only screen and (max-width: 768px) {
                #particles-js {
                    background-position: 70% 50%; /* Align the image to the top center on mobile */
                    background-size: cover; /* Ensure the image still covers the screen */
                }
            }
        </style>
    @else
        <style>
            @media only screen and (max-width: 768px) {
                #particles-js {
                    background-position: 50% 50%; /* Align the image to the top center on mobile */
                    background-size: cover; /* Ensure the image still covers the screen */
                }
            }
        </style>
    @endif
</head>

<body class="nk-body" data-sidebar-collapse="lg" data-navbar-collapse="lg">
    

    <!-- Root  -->
    <div class="nk-app-root">
        <!-- main  -->
        <div class="nk-main">
            <div class="nk-wrap align-items-center justify-content-center has-mask">
                <!-- Particles.js container -->
                <div id="particles-js"></div>
                {{-- <div class="mask mask-3"></div><!-- .mask--> --}}
                @yield('content')
            </div>
        </div> <!-- .nk-main -->
    </div> <!-- .nk-app-root -->

    <!-- JavaScript libraries -->
    <script src="./assets/js/bundle.js"></script>
    <script src="./assets/js/scripts.js"></script>

    <!-- Load Particles.js library -->
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>

    <script>
        // Check if the session has a 'success' message and trigger SweetAlert
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: "{{ session('success') }}",
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK'
            });
        @elseif (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: "{{ session('error') }}",
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK'
            });
        @endif

        // Initialize Particles.js
        document.addEventListener("DOMContentLoaded", function () {
            particlesJS("particles-js", {
                "particles": {
                    "number": {
                        "value": 160,
                        "density": {
                            "enable": true,
                            "value_area": 800
                        }
                    },
                    "color": {
                        // "value": "#ffffff"
                        "value": "#c9c9c9" // Set particles to grey
                    },
                    "shape": {
                        "type": "circle",
                        "stroke": {
                            "width": 0,
                            "color": "#000000"
                        },
                        "polygon": {
                            "nb_sides": 5
                        },
                        "image": {
                            "src": "img/github.svg",
                            "width": 100,
                            "height": 100
                        }
                    },
                    "opacity": {
                        "value": 0.5,
                        "random": false,
                        "anim": {
                            "enable": false,
                            "speed": 1,
                            "opacity_min": 0.1,
                            "sync": false
                        }
                    },
                    "size": {
                        "value": 3,
                        "random": true,
                        "anim": {
                            "enable": false,
                            "speed": 40,
                            "size_min": 0.1,
                            "sync": false
                        }
                    },
                    "line_linked": {
                        "enable": true,
                        "distance": 150,
                        "color": "#c9c9c9",
                        "opacity": 0.4,
                        "width": 1
                    },
                    "move": {
                        "enable": true,
                        "speed": 6,
                        "direction": "none",
                        "random": false,
                        "straight": false,
                        "out_mode": "out",
                        "bounce": false,
                        "attract": {
                            "enable": false,
                            "rotateX": 600,
                            "rotateY": 1200
                        }
                    }
                },
                "interactivity": {
                    "detect_on": "canvas",
                    "events": {
                        "onhover": {
                            "enable": true,
                            "mode": "grab"
                        },
                        "onclick": {
                            "enable": true,
                            "mode": "push"
                        },
                        "resize": true
                    },
                    "modes": {
                        "grab": {
                            "distance": 400,
                            "line_linked": {
                                "opacity": 1
                            }
                        },
                        "bubble": {
                            "distance": 400,
                            "size": 40,
                            "duration": 2,
                            "opacity": 8,
                            "speed": 3
                        },
                        "repulse": {
                            "distance": 200,
                            "duration": 0.4
                        },
                        "push": {
                            "particles_nb": 4
                        },
                        "remove": {
                            "particles_nb": 2
                        }
                    }
                },
                "retina_detect": true
            });
        });
    </script>
</body>

</html>
