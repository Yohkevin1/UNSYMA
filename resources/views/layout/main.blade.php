<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('/img/UNISEC.png') }}">
  <link rel="icon" type="image/png" href="{{ asset('/img/UNISEC.png') }}">
  <meta name="keywords" content="unisec, UNISEC, UAJY, unisec uajy">
  <meta name="description" content="Sistem Administrasi Unisec UAJY">
  <title>@yield('title')</title>
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <link href="{{ asset('css/nucleo-icons.css')}}" rel="stylesheet" />
  <link href="{{ asset('css/nucleo-svg.css')}}" rel="stylesheet" />
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link id="pagestyle" href="{{ asset('css/argon-dashboard.css') }}" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" crossorigin="anonymous"/>
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <script src="{{ asset('js/plugins/chartjs.min.js') }}"></script>
</head>

<body class="g-sidenav-show bg-gray-100">
  <div class="position-absolute w-100 min-height-300 top-0" style="background-image: url('{{ asset('/img/UNISEC.png') }}'); background-position-y: 50%;">
    <span class="mask bg-primary opacity-6"></span>
  </div>
  @include('layout.sidebar')
  <main class="main-content position-relative border-radius-lg ">
    @include('layout.navbar')
    <div class="container-fluid py-4">
      @yield('content')
      <footer class="footer pt-3 ">
        <div class="row align-items-center justify-content-lg-between">
            <div class="col-lg-6 mb-lg-0 mb-4">
                <div class="copyright text-center text-sm text-muted text-lg-start">
                © <script>
                    document.write(new Date().getFullYear())
                </script>,
                made with <i class="fa fa-heart"></i> by UNISEC
                </div>
            </div>
        </div>
      </footer>
    </div>
  </main>
  <!--   Core JS Files   -->
  <script src="{{ asset('js/core/popper.min.js') }}"></script>
  <script src="{{ asset('js/core/bootstrap.min.js') }}"></script>
  <script src="{{ asset('js/plugins/perfect-scrollbar.min.js') }}"></script>
  <script src="{{ asset('js/plugins/smooth-scrollbar.min.js') }}"></script>
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <script src="{{ asset('js/argon-dashboard.js') }}"></script>
  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script>
      @if(Session::has('message'))
        var type = "{{Session::get('alert-type', 'info')}}"
        switch (type) {
            case 'info':
                toastr.info("{{Session::get('message')}}");
                break;
            case 'success':
                toastr.success("{{Session::get('message')}}");
                break;
            case 'warning':
                toastr.warning("{{Session::get('message')}}");
                break;
            case 'error':
                toastr.error("{{Session::get('message')}}");
                break;
        }
      @endif

      function previewImage() {
          const foto = document.querySelector('#foto');
          const imgPreview = document.querySelector('.img-preview');
          const fileSampul = new FileReader();
          fileSampul.readAsDataURL(foto.files[0]);
          fileSampul.onload = function(e) {
              imgPreview.src = e.target.result;
          }
      }

      var win = navigator.platform.indexOf('Win') > -1;
      if (win && document.querySelector('#sidenav-scrollbar')) {
        var options = {
          damping: '0.5'
        }
        Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
      }

      $(document).ready(function() {
        $('.dataTable').DataTable();
    });
  </script> 
</body>
</html>