@php
    $allsetting = allsetting();
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="{{$allsetting['meta_description']}}">
    <meta name="keywords" content="{{$allsetting['meta_keywords']}}">
    <meta name="author" content="{{$allsetting['meta_author']}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta property="og:type" content="{{__('Web Template')}}">
    <meta property="og:title" content="{{$allsetting['meta_title']}}">
    <meta property="og:description" content="{{$allsetting['meta_description']}}">
    <meta property="og:image" content="{{asset('assets/user/img/01_preview.png')}}">
    <meta name="twitter:card" content="{{$allsetting['meta_author']}}">
    <meta name="twitter:title" content="{{$allsetting['meta_title']}}">
    <meta name="twitter:description" content="{{$allsetting['meta_description']}}">
    <meta name="twitter:image" content="{{asset('assets/user/img/01_preview.png')}}">
    <meta name="msapplication-TileImage" content="{{asset('assets/user/img/01_preview.png')}}">
    <meta name="msapplication-TileColor" content="rgba(103, 20, 222,.55)">
    <meta name="theme-color" content="#69B756">
    @yield('style')
    <title>@yield('title') {{__('| '.$allsetting['meta_title'])}}</title>
    <!--=======================================
      All Css Style link
    ===========================================-->
    <!-- Bootstrap core CSS -->
    <link href="{{asset('assets/user/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">

    <link href="{{asset('assets/user/css/jquery-ui.min.css')}}" rel="stylesheet">

    <!-- Font Awesome for this template -->
    <link href="{{asset('assets/user/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">

    <!-- Flat Icon for this template -->
    <link href="{{asset('assets/user/vendor/flat-icon/flaticon.css')}}" rel="stylesheet" type="text/css">

    <!-- Custom fonts for this template -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,wght@0,400;0,500;0,700;1,400;1,500;1,700&display=swap" rel="stylesheet">

    <!-- Animate Css-->
    <link rel="stylesheet" href="{{asset('assets/user/css/animate.min.css')}}">

    <link rel="stylesheet" href="{{asset('assets/user/css/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/user/css/owl.theme.default.min.css')}}">

    <!-- DataTables -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/user/vendor/datatable/css/dataTables.bootstrap4.min.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('assets/user/vendor/datatable/css/responsive.dataTables.min.css')}}"/>

    <link rel="stylesheet" href="{{asset('assets/user/css/nice-select.css')}}">

    <!-- Custom styles for this template -->
    <link href="{{asset('assets/user/css/style.css')}}" rel="stylesheet">
    <!-- Extra CSS -->
    <link href="{{asset('assets/user/css/extra.css')}}" rel="stylesheet">

    <!-- Responsive Css-->
    <link rel="stylesheet" href="{{asset('assets/user/css/responsive.css')}}">

    @stack('post_styles')

    <!-- FAVICONS -->
    <link rel="icon" href="{{asset('assets/user/img/favicon-16x16.png')}}" type="image/png" sizes="16x16')}}">
    <link rel="shortcut icon" href="{{asset('assets/user/img/favicon-16x16.png')}}" type="image/x-icon')}}">
    <link rel="shortcut icon" href="{{asset(IMG_PATH.$allsetting['favicon'])}}">

    <link rel="apple-touch-icon-precomposed" type="image/x-icon" href="{{asset('assets/user/img/apple-icon-72x72.png')}}" sizes="72x72" />
    <link rel="apple-touch-icon-precomposed" type="image/x-icon" href="{{asset('assets/user/img/apple-icon-114x114.png')}}" sizes="114x114" />
    <link rel="apple-touch-icon-precomposed" type="image/x-icon" href="{{asset('assets/user/img/apple-icon-144x144.png')}}" sizes="144x144"/>
    <link rel="apple-touch-icon-precomposed" type="image/x-icon" href="{{asset('assets/user/img/favicon-16x16.png')}}" />
    <script src="https://cdn.jsdelivr.net/npm/web3@latest/dist/web3.min.js"></script>
    <script src="https://unpkg.com/moralis/dist/moralis.js"></script>
{{--    <script src="{{asset('assets/user/js/moralis.js')}}"></script>--}}
    <script>
        const serverUrl = "{{env("MORALIS_SERVER_URL")}}";
        const appId = "{{env("MORALIS_APPLICATION_ID")}}";
        const contract_abi = [{"inputs":[{"internalType":"uint256","name":"price","type":"uint256"},{"internalType":"uint256","name":"fees","type":"uint256"},{"internalType":"address","name":"contractAddr","type":"address"},{"internalType":"uint256","name":"tokenId","type":"uint256"}],"name":"addListing","outputs":[],"stateMutability":"nonpayable","type":"function"},{"inputs":[],"stateMutability":"nonpayable","type":"constructor"},{"anonymous":false,"inputs":[{"indexed":true,"internalType":"address","name":"owner","type":"address"},{"indexed":true,"internalType":"address","name":"approved","type":"address"},{"indexed":true,"internalType":"uint256","name":"tokenId","type":"uint256"}],"name":"Approval","type":"event"},{"anonymous":false,"inputs":[{"indexed":true,"internalType":"address","name":"owner","type":"address"},{"indexed":true,"internalType":"address","name":"operator","type":"address"},{"indexed":false,"internalType":"bool","name":"approved","type":"bool"}],"name":"ApprovalForAll","type":"event"},{"inputs":[{"internalType":"address","name":"to","type":"address"},{"internalType":"uint256","name":"tokenId","type":"uint256"}],"name":"approve","outputs":[],"stateMutability":"nonpayable","type":"function"},{"inputs":[{"internalType":"address","name":"contractAddr","type":"address"},{"internalType":"uint256","name":"tokenId","type":"uint256"},{"internalType":"uint256","name":"amount","type":"uint256"},{"internalType":"uint256","name":"fees","type":"uint256"},{"internalType":"address payable","name":"destAddr","type":"address"},{"internalType":"address payable","name":"adminAddr","type":"address"}],"name":"balanceTransferToOwner","outputs":[],"stateMutability":"nonpayable","type":"function"},{"inputs":[{"internalType":"address","name":"contractAddr","type":"address"},{"internalType":"uint256","name":"tokenId","type":"uint256"}],"name":"deposit","outputs":[],"stateMutability":"payable","type":"function"},{"inputs":[{"internalType":"string","name":"_uri","type":"string"}],"name":"mint","outputs":[],"stateMutability":"payable","type":"function"},{"inputs":[{"internalType":"address","name":"contractAddr","type":"address"},{"internalType":"uint256","name":"tokenId","type":"uint256"},{"internalType":"uint256","name":"amount","type":"uint256"},{"internalType":"uint256","name":"fees","type":"uint256"},{"internalType":"address payable","name":"destAddr","type":"address"},{"internalType":"address payable","name":"adminAddr","type":"address"}],"name":"purchase","outputs":[],"stateMutability":"nonpayable","type":"function"},{"inputs":[{"internalType":"address","name":"from","type":"address"},{"internalType":"address","name":"to","type":"address"},{"internalType":"uint256","name":"tokenId","type":"uint256"}],"name":"safeTransferFrom","outputs":[],"stateMutability":"nonpayable","type":"function"},{"inputs":[{"internalType":"address","name":"from","type":"address"},{"internalType":"address","name":"to","type":"address"},{"internalType":"uint256","name":"tokenId","type":"uint256"},{"internalType":"bytes","name":"_data","type":"bytes"}],"name":"safeTransferFrom","outputs":[],"stateMutability":"nonpayable","type":"function"},{"inputs":[{"internalType":"address","name":"operator","type":"address"},{"internalType":"bool","name":"approved","type":"bool"}],"name":"setApprovalForAll","outputs":[],"stateMutability":"nonpayable","type":"function"},{"anonymous":false,"inputs":[{"indexed":true,"internalType":"address","name":"from","type":"address"},{"indexed":true,"internalType":"address","name":"to","type":"address"},{"indexed":true,"internalType":"uint256","name":"tokenId","type":"uint256"}],"name":"Transfer","type":"event"},{"inputs":[{"internalType":"address","name":"from","type":"address"},{"internalType":"address","name":"to","type":"address"},{"internalType":"uint256","name":"tokenId","type":"uint256"}],"name":"transferFrom","outputs":[],"stateMutability":"nonpayable","type":"function"},{"inputs":[{"internalType":"address","name":"contractAddr","type":"address"},{"internalType":"uint256","name":"tokenId","type":"uint256"},{"internalType":"uint256","name":"amount","type":"uint256"},{"internalType":"uint256","name":"fees","type":"uint256"},{"internalType":"address payable","name":"destAddr","type":"address"},{"internalType":"address payable","name":"adminAddr","type":"address"}],"name":"withdraw","outputs":[],"stateMutability":"nonpayable","type":"function"},{"inputs":[{"internalType":"address","name":"owner","type":"address"}],"name":"balanceOf","outputs":[{"internalType":"uint256","name":"","type":"uint256"}],"stateMutability":"view","type":"function"},{"inputs":[{"internalType":"address","name":"","type":"address"}],"name":"balances","outputs":[{"internalType":"uint256","name":"","type":"uint256"}],"stateMutability":"view","type":"function"},{"inputs":[{"internalType":"uint256","name":"tokenId","type":"uint256"}],"name":"getApproved","outputs":[{"internalType":"address","name":"","type":"address"}],"stateMutability":"view","type":"function"},{"inputs":[],"name":"getBalance","outputs":[{"internalType":"uint256","name":"","type":"uint256"}],"stateMutability":"view","type":"function"},{"inputs":[{"internalType":"address","name":"owner","type":"address"},{"internalType":"address","name":"operator","type":"address"}],"name":"isApprovedForAll","outputs":[{"internalType":"bool","name":"","type":"bool"}],"stateMutability":"view","type":"function"},{"inputs":[{"internalType":"address","name":"","type":"address"},{"internalType":"uint256","name":"","type":"uint256"}],"name":"listings","outputs":[{"internalType":"uint256","name":"price","type":"uint256"},{"internalType":"uint256","name":"fees","type":"uint256"},{"internalType":"address","name":"seller","type":"address"}],"stateMutability":"view","type":"function"},{"inputs":[],"name":"mintPrice","outputs":[{"internalType":"uint256","name":"","type":"uint256"}],"stateMutability":"view","type":"function"},{"inputs":[],"name":"name","outputs":[{"internalType":"string","name":"","type":"string"}],"stateMutability":"view","type":"function"},{"inputs":[{"internalType":"uint256","name":"tokenId","type":"uint256"}],"name":"ownerOf","outputs":[{"internalType":"address","name":"","type":"address"}],"stateMutability":"view","type":"function"},{"inputs":[{"internalType":"bytes4","name":"interfaceId","type":"bytes4"}],"name":"supportsInterface","outputs":[{"internalType":"bool","name":"","type":"bool"}],"stateMutability":"view","type":"function"},{"inputs":[],"name":"symbol","outputs":[{"internalType":"string","name":"","type":"string"}],"stateMutability":"view","type":"function"},{"inputs":[{"internalType":"uint256","name":"index","type":"uint256"}],"name":"tokenByIndex","outputs":[{"internalType":"uint256","name":"","type":"uint256"}],"stateMutability":"view","type":"function"},{"inputs":[{"internalType":"address","name":"owner","type":"address"},{"internalType":"uint256","name":"index","type":"uint256"}],"name":"tokenOfOwnerByIndex","outputs":[{"internalType":"uint256","name":"","type":"uint256"}],"stateMutability":"view","type":"function"},{"inputs":[{"internalType":"uint256","name":"tokenId","type":"uint256"}],"name":"tokenURI","outputs":[{"internalType":"string","name":"","type":"string"}],"stateMutability":"view","type":"function"},{"inputs":[],"name":"totalSupply","outputs":[{"internalType":"uint256","name":"","type":"uint256"}],"stateMutability":"view","type":"function"}];
        const nft_contract_address = "{{env("CONTRACT_ADDRESS")}}"; //NFT Minting Contract Use This One "Batteries Included", code of this contract is in the github repository under contract_base for your reference.
        const admin_contract_address = "{{env("ADMIN_ADDRESS")}}";
        const trans_fees = "{{env("FEE_PERCENT")}}";
        const web3 = new Web3(window.ethereum);
        const contract = new web3.eth.Contract(contract_abi, nft_contract_address);
        Moralis.start({ serverUrl, appId });
        function setCookie(name,value,days) {
            var expires = "";
            if (days) {
                var date = new Date();
                date.setTime(date.getTime() + (days*24*60*60*1000));
                expires = "; expires=" + date.toUTCString();
            }
            document.cookie = name + "=" + (value || "")  + expires + "; path=/";
        }
        function getCookie(name) {
            var nameEQ = name + "=";
            var ca = document.cookie.split(';');
            for(var i=0;i < ca.length;i++) {
                var c = ca[i];
                while (c.charAt(0)==' ') c = c.substring(1,c.length);
                if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
            }
            return null;
        }
        function eraseCookie(name) {
            document.cookie = name +'=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
        }
        function login(){
            var body = {
                'username' : getCookie('_un'),
                'eth_address' : getCookie('_ea'),
                '_token'  : '{{csrf_token()}}'
            }
            $.ajax({
                type: 'POST',
                url: '{{Route('auth_check')}}',
                data: body,
                dataType: 'json',
                success: function(data) {
                    console.log('data99999');
                    if(data['message'] == 'reload'){
                        window.location.reload()
                    }
                    console.log(data);
                },
                error: function(data) {
                    console.log(data);
                }
            });
        }
        function logout(){
            $.ajax({
                type: 'GET',
                url: '{{Route('logOut')}}',
                dataType: 'json',
                success: function(data) {
                    Moralis.User.logOut().then(() => {
                        eraseCookie('_ea');
                        eraseCookie('_un');
                        eraseCookie('_be');
                    });
                    window.location.reload()
                }
            });
        }
        function truncate(text, startChars, endChars, maxLength) {
            if (text.length > maxLength) {
                var start = text.substring(0, startChars);
                var end = text.substring(text.length - endChars, text.length);
                while ((start.length + end.length) < maxLength)
                {
                    start = start + '.';
                }
                return start + end;
            }
            return text;
        }
        function copyToClipboard(element) {
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val($(element).val()).select();
            document.execCommand("copy");
            $temp.remove();
        }

        function ongoingSnippet(title, description) {
            return "<div class='purchasing-process-box'><div class='purchasing-process-box d-flex align-items-center'><div class='follow-step-content-left steps__icon purchasing-process-left mr-3'><div class='loader-circle'></div></div><div class='purchasing-process-right'> <h6 class='steps__info'>"+ title +"</h6> <div class='steps__text'>"+ description +"</div></div></div></div>"
        }

        function pendingSnippet(title, description) {
            return "<div class='follow-step-modal-box purchasing-process-box'><div class='follow-step-content-box d-flex align-items-center'><div class='follow-step-content-left mr-3'><i class='fas fa-check'></i> </div> <div class='follow-step-content-right'> <h6>"+ title +"</h6> <p>"+ description +"</p> </div> </div> </div>"
        }

        function doneSnippet(title, description) {
            return "<div class='follow-step-modal-box step-done-btn purchasing-process-box'><div class='follow-step-content-box d-flex align-items-center'><div class='follow-step-content-left mr-3'> <i class='fas fa-check'></i> </div> <div class='follow-step-content-right'> <h6>"+ title +"</h6> <p>"+ description +"</p> </div> </div> </div>"
        }

        function goToMyArtworks() {
            window.location.href = "/user/my-collections";
        }

        function reloadPage() {
            window.location.reload(true);
        }
    </script>
</head>
<body class="{{session()->has('lang_dir') && session()->get('lang_dir') == 'rtl' ? 'direction-rtl' : 'direction-ltr'}}">
@include('user.message')
<!-- Pre Loader Area start -->
<div id="preloader">
    <div id="status" style="background-image: url({{is_null($allsetting['preloader_logo']) || $allsetting['preloader_logo'] == '' ? asset(IMG_STATIC_PATH.'preloader.png') : asset(IMG_PATH.$allsetting['preloader_logo'])}})"></div>
</div>
<!-- Pre Loader Area End -->

<!--Main Menu/Navbar Area Start -->

@include('user.menu')

<!-- Offcanvas Overlay -->
<div class="offcanvas-overlay"></div>
@yield('content')

@include('user.footer')
@include('user.modal')
<!-- ======================================
    All Jquery Script link
===========================================-->

<!-- Bootstrap core JavaScript -->
<script src="{{asset('assets/user/vendor/jquery/jquery-3.6.0.min.js')}}"></script>
<script src="{{asset('assets/user/vendor/jquery/popper.min.js')}}"></script>
<script src="{{asset('assets/user/vendor/bootstrap/js/bootstrap.min.js')}}"></script>

<!-- ==== Plugin JavaScript ==== -->

<script src="{{asset('assets/user/vendor/jquery-easing/jquery.easing.min.js')}}"></script>

<script src="{{asset('assets/user/js/jquery-ui.min.js')}}"></script>

<!--WOW JS Script-->
<script src="{{asset('assets/user/js/wow.min.js')}}"></script>

<!--WayPoints JS Script-->
<script src="{{asset('assets/user/js/waypoints.min.js')}}"></script>

<!--Counter Up JS Script-->
<script src="{{asset('assets/user/js/jquery.counterup.min.js')}}"></script>

<script src="{{asset('assets/user/js/owl.carousel.min.js')}}"></script>

<!--Countdown Script-->
@if(Route::is('login'))
<script src="{{asset('assets/user/js/multi-countdown.js')}}"></script>
@endif

<!--niceSelect JS Script-->
<script src="{{asset('assets/user/js/jquery.nice-select.min.js')}}"></script>

<script src="{{asset('assets/user/js/TweenMax.min.js')}}"></script>

<!-- Range Slider -->
<script src="{{asset('assets/user/js/price_range_script.js')}}"></script>

<!-- Menu js -->
<script src="{{asset('assets/user/js/menu.js')}}"></script>

<!-- Datatables js -->
<script src="{{asset('assets/user/vendor/datatable/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/user/vendor/datatable/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/user/vendor/datatable/js/dataTables.responsive.min.js')}}"></script>

<!-- Custom scripts for this template -->
<script src="{{asset('assets/user/js/custom.js')}}"></script>

<script src="{{asset('assets/user/js/qrcode.min.js')}}"></script>

<!-- Bootstrap core JavaScript -->
@include('user.common')
@yield('script')
<script>
$('.my-eth-address').html(truncate(getCookie('_ea'),10,5,20));
$('.show-blanace').html(truncate(getCookie('_be'),10,5,20));
$('#my-eth-address').val(getCookie('_ea'))
</script>
</body>

</html>
