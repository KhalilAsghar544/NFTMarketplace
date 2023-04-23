@extends('user.master')
@section('title', isset($title) ? $title : __('Marketplace'))
@section('content')
    <!-- Page Banner Area start here  -->
    <section class="page-banner-area p-0" style="background-image: url({{is_null(allsetting()['dashboard_image']) || allsetting()['dashboard_image'] == '' ? cdnAsset(IMG_STATIC_PATH,'page-banner.png') : cdnAsset(IMG_PATH,allsetting()['dashboard_image'])}});">
        <div class="container">
            <!-- Page Banner element -->
            <div class="inner-page-single-dot1 position-absolute"><img src="{{cdnAsset('assets/user/img/footer-img/','footer-dot1.png')}}" alt="{{__('main.dot')}}"></div>
            <div class="inner-page-single-dot2 position-absolute"><img src="{{cdnAsset('assets/user/img/footer-img/','footer-dot2.png')}}" alt="{{__('main.dot')}}"></div>
            <div class="inner-page-single-dot3 position-absolute"><img src="{{cdnAsset('assets/user/img/footer-img/','footer-dot3.png')}}" alt="{{__('main.dot')}}"></div>
            <!-- Page Banner element -->
            <div class="row page-banner-top-space">
                <div class="col-12 col-lg-12">
                    <div class="page-banner-content text-center">
                        <h1 class="page-banner-title">{{__('main.Explore')}}</h1>
                        <p class="page-banner-para">{{__('main.hottest-crypto-assets-text')}}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Page Banner Area end here  -->
    <!-- Page Breadcrumb Area start here  -->
    <section class="breadcrumb-section p-0">
        <div class="container">
            <div class="row">
                <!-- Breadcrumb Area -->
                <div class="col-12">
                    <nav aria-label="breadcrumb" class="breadcrumb-area">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('login')}}">{{__('main.Home')}}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{__('main.Explore')}}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <!-- Page Breadcrumb Area end here  -->
    <!-- northern light carousel Area Start -->
    <section class="northern-light-area place-a-bid-page main-items-area section-t-space section-b-90-space">
        <div class="container">
            <div class="main-items-carousel">
                <div class="main-items-carousel position-relative">
                    <!-- main item slider start -->
                    <div class="main-item">
                        <div class="row" id="post">



                        </div>
                    </div>
                    <!-- main item slider end -->
                </div>
            </div>
        </div>
    </section>
    <div id="showModal"></div>
    <!-- northern light carousel Area End -->
    <div data-id="{{$token_address}}" id="token_address"></div>
    <div data-id="{{$token_id}}" id="token_id"></div>
    <div data-id="{{route('ajax_nft_details')}}" id="ajax_nft_details"></div>
@endsection
@section('script')
    <script src="{{asset('assets/user/js/multi-countdown.js')}}"></script>
    @if (Auth::check() && Auth::user()->role == 2)
        <script src="{{asset('assets/user/js/pages/product-view.js')}}"></script>
    @endif
    <script>
        nftDetails();

        async function nftDetails() {
            let user = Moralis.User.current();
            let formData = new FormData();
            formData.append('token_address', $('#token_address').data('id'));
            formData.append('token_id', $('#token_id').data('id'));
            formData.append('_token', $('meta[name="csrf-token"]').attr('content'));

            const options = { chain: '{{env('CHAIN')}}', address: $('#token_address').data('id'), token_id: String($('#token_id').data('id')) };
            const nft = await Moralis.Web3API.token.getTokenIdMetadata(options);
            console.log(nft)
            const listings = await contract.methods.listings($('#token_address').data('id'), $('#token_id').data('id')).call();
            console.log(listings.price)
            let d_name = nft.name != null ? nft.name : nft.block_number_minted;
            let nft_name = d_name +":"+ nft.token_id;
            let nft_image = '/assets/user/img/placeholder.webp';
            let put_on_sale_html = "";
            let price_set = "";
            let totalSumCharge = 0;
            if(!user) {
                put_on_sale_html = "<button class='theme-button1 w-100 add-listing'>Connect Wallet</button>";
            }else {
                if(user.get("ethAddress") == nft.owner_of) {
                    if(listings.price != 0) {
                        put_on_sale_html = "<button class='theme-button1 w-100 add-listing'>NFT Listed</button>";
                        price_set = "<p class='font-weight-bold color-heading'>Price</p><div class='bid-price-box'><h2>"+ web3.utils.fromWei(listings.price, 'ether') +" <span class='bid-small-price'>ETH</span></h2></div>";
                    }else {
                        put_on_sale_html = "<button class='theme-button1 w-100 add-listing' onclick='onSaleModalShow()'>Put On Sale</button>";
                    }
                }else {
                    if(listings.price != 0) {
                        totalSumCharge = parseInt(listings.price) + parseInt(listings.fees);
                        // put_on_sale_html = "<button class='theme-button1 w-100 add-listing' onclick='purchase(\""+ $('#token_address').data('id') +"\", "+ $('#token_id').data('id') +", "+ listings.price +", "+ listings.fees +", \""+ nft.owner_of +"\")'>Buy</button>";
                        put_on_sale_html = "<button class='theme-button1 w-100 add-listing' onclick='purchaseModal()'>Buy</button>";
                        price_set = "<p class='font-weight-bold color-heading'>Price</p><div class='bid-price-box'><h2>"+ web3.utils.fromWei(listings.price, 'ether') +" <span class='bid-small-price'>ETH</span></h2></div>";
                    }else {
                        put_on_sale_html = "<button class='theme-button1 w-100 add-listing'>NFT Not Listed</button>";
                    }
                }
            }
            if(nft.metadata != null) {
                let data = JSON.parse(nft.metadata);
                nft_name = data.name;
                nft_image = data.image;
            }
            $.ajax({
                type: 'post',
                contentType: false,
                processData: false,
                // async:false,
                url: $('#ajax_nft_details').data('id'),
                data: formData,
                dataType: 'json',
                success: async function(nft_data) {
                    if(nft_data.success == true) {
                        let lockable_html = '';
                        if(nft_data.value.is_unlockable == 1) {
                            lockable_html = "<span class='badge badge-pill'>Unlockable</span>";
                        }
                        $("#post").html($("#post").html()
                            + "<div class='col-12 col-md-12 col-lg-5'>"
                            + "<div class='main-item-content-part'>"
                            + "<h2 class='section-heading'>"+ nft_name +"</h2>"
                            + "<div class='main-item-views-love d-flex align-items-center justify-content-between'>"
                            + "<div class='main-item-views-part d-flex align-items-center'>"
                            + "<span>In Stock: "+nft.amount+"</span>"
                            + "<span>Sell: "+nft.amount+"</span>"
                            + "</div>"
                            + "<div class='main-item-love-part'>"
                            + "<button class='color-red' id='like_now'><i class='far fa-heart'></i></button> <span class='font-weight-bold color-heading' id='like_count'>"+ nft_data.value.like +"</span>"
                            + "</div>"
                            + "</div>"
                            + "<input type='hidden' id='likeable' value='0'>"
                            + "<input type='hidden' id='s-like-store' value=''>"
                            + "<input type='hidden' id='s-like-remove' value=''>"
                            + "<input type='hidden' id='sid' value=''>"
                            + "<div class='main-item-leftside-box'>"
                            + "<div class='current-bid-box'>"
                            + "<p class='font-weight-bold color-heading'>Address:</p>"
                            + "<a href='{{env('EXPLORER_URL')}}/address/"+ nft.token_address+ "' target='_blank'>"+ truncate(nft.token_address,10,5,20)+ "</a>"
                            + price_set
                            + "</div>"
                            + "<div class='owner-creator-box'>"
                            + "<div class='owner-box'>"
                            + "<img src='"+ fixURL(nft_image) +"' alt='"+ nft_name +"'>"
                            + "<h6>"+ truncate(nft.owner_of,10,5,20) +"</h6>"
                            + "<p>Owner</p>"
                            + "</div>"
                            + "</div>"
                            + "</div>"


                            + "<div class='main-item-leftside-box'>"
                            + "<div class='highest-bid-box d-flex align-items-center justify-content-between'>"
                            + "<div class='highest-box-item d-flex align-items-center'>"
                            + "<img src='/assets/user/img/main-item-img/color-icon.png' alt='color'>"
                            + "<div class='highest-box-text'>"
                            + "<p>Color</p>"
                            + "<h6>"+ nft_data.value.color +"</h6>"
                            + "</div>"
                            + "</div>"
                            + "<div class='highest-box-item d-flex align-items-center'>"
                            + "<img src='/assets/user/img/main-item-img/country-icon.png' alt='bid'>"
                            + "<div class='highest-box-text'>"
                            + "<p>Origin</p>"
                            + "<h6>"+ nft_data.value.origin +"</h6>"
                            + "</div>"
                            + "</div>"
                            + "</div>"
                            + "<div class='main-item-btn-box'>"
                            + put_on_sale_html
                            + "</div>"
                            + "<p class='main-item-box-condition text-center'>"
                            + "<span class='font-semi-bold'>Transfer History</span>"
                            + "<span><button data-toggle='modal' href='#transactionHistoryModal1'>Click here</button></span>"
                            + "</p>"
                            + "</div>"
                            + "</div>"
                            + "</div>"


                            + "<div class='col-12 col-md-12 col-lg-7'>"
                            + "<div class='main-item-img-part position-relative d-flex justify-content-center'>"
                            + "<div class='main-item-img'>"
                            + "<img src='"+ fixURL(nft_image) +"' alt='"+ nft_name +"'>"
                            + "</div>"
                            + "<div class='main-item-upper-box position-absolute w-100 d-flex justify-content-between'>"
                            + "<div class='main-item-upper-left'>"
                            + "<span class='badge badge-pill'>"+ nft_data.value.category.title +"</span>"
                            + lockable_html
                            + "</div>"
                            + "</div>"
                            + "</div>"
                            + "</div>");
                    }else {
                        $("#post").html($("#post").html()
                            + "<div class='col-12 col-md-12 col-lg-5'>"
                            + "<div class='main-item-content-part'>"
                            + "<h2 class='section-heading'>"+ nft_name +"</h2>"
                            + "<div class='main-item-views-love d-flex align-items-center justify-content-between'>"
                            + "<div class='main-item-views-part d-flex align-items-center'>"
                            + "<span>In Stock: "+nft.amount+"</span>"
                            + "<span>Sell: "+nft.amount+"</span>"
                            + "</div>"
                            + "<div class='main-item-love-part'>"
                            + "<button class='color-red' id='like_now'><i class='far fa-heart'></i></button> <span class='font-weight-bold color-heading' id='like_count'>0</span>"
                            + "</div>"
                            + "</div>"
                            + "<input type='hidden' id='likeable' value='0'>"
                            + "<input type='hidden' id='s-like-store' value=''>"
                            + "<input type='hidden' id='s-like-remove' value=''>"
                            + "<input type='hidden' id='sid' value=''>"
                            + "<div class='main-item-leftside-box'>"
                            + "<div class='current-bid-box'>"
                            + "<p class='font-weight-bold color-heading'>Address:</p>"
                            + "<a href='{{env('EXPLORER_URL')}}/address/"+ nft.token_address+ "' target='_blank'>"+ truncate(nft.token_address,10,5,20)+ "</a>"
                            + price_set
                            + "</div>"
                            + "<div class='owner-creator-box'>"
                            + "<div class='owner-box'>"
                            + "<img src='"+ fixURL(nft_image) +"' alt='"+ nft_name +"'>"
                            + "<h6>"+ truncate(nft.owner_of,10,5,20) +"</h6>"
                            + "<p>Owner</p>"
                            + "</div>"
                            + "</div>"
                            + "</div>"


                            + "<div class='main-item-leftside-box'>"
                            + "<div class='highest-bid-box d-flex align-items-center justify-content-between'>"
                            + "<div class='highest-box-item d-flex align-items-center'>"
                            + "<img src='/assets/user/img/main-item-img/color-icon.png' alt='color'>"
                            + "<div class='highest-box-text'>"
                            + "<p>Color</p>"
                            + "<h6>N/A</h6>"
                            + "</div>"
                            + "</div>"
                            + "<div class='highest-box-item d-flex align-items-center'>"
                            + "<img src='/assets/user/img/main-item-img/country-icon.png' alt='bid'>"
                            + "<div class='highest-box-text'>"
                            + "<p>Origin</p>"
                            + "<h6>N/A</h6>"
                            + "</div>"
                            + "</div>"
                            + "</div>"
                            + "<div class='main-item-btn-box'>"
                            + put_on_sale_html
                            + "</div>"
                            + "<p class='main-item-box-condition text-center'>"
                            + "<span class='font-semi-bold'>Transfer History</span>"
                            + "<span><button data-toggle='modal' href='#transactionHistoryModal1'>Click here</button></span>"
                            + "</p>"
                            + "</div>"
                            + "</div>"
                            + "</div>"


                            + "<div class='col-12 col-md-12 col-lg-7'>"
                            + "<div class='main-item-img-part position-relative d-flex justify-content-center'>"
                            + "<div class='main-item-img'>"
                            + "<img src='"+ fixURL(nft_image) +"' alt='"+ nft_name +"'>"
                            + "</div>"
                            + "<div class='main-item-upper-box position-absolute w-100 d-flex justify-content-between'>"
                            + "<div class='main-item-upper-left'>"
                            + "<span class='badge badge-pill'>Not Categorize</span>"
                            + "</div>"
                            + "</div>"
                            + "</div>"
                            + "</div>");
                    }

                    $("#showModal").html($("#showModal").html()
                        + "<div class='modal fade common-modal preview-inner-modal' id='changePriceModal' tabindex='-1' aria-labelledby='changePriceModalLabel aria-hidden='true'>"
                        + "<div class='modal-dialog modal-dialog-centered'>"
                        + "<div class='modal-content'>"
                        + "<div class='modal-header p-0'>"
                        + "<h4 class='modal-title' id='changePriceModalLabel'>Set Price</h4>"
                        + "<button type='button' class='close' data-dismiss='modal' aria-label='Close'>"
                        + "<span aria-hidden='true'>&times;</span>"
                        + "</button>"
                        + "</div>"
                        + "<div class='modal-body p-0'>"
                        + "<div class='change-price-box'>"
                        + "<form>"
                        + "<p class='font-semi-bold color-heading'>Write new price here</p>"
                        + "<div class='form-group'>"
                        + "<input id='token_id' type='hidden' value='"+ nft.token_id +"'>"
                        + "<input class='form-control' id='price' placeholder='Set Price' type='text' value='0.001' required>"
                        + "<span class='position-absolute color-heading change-price-currency'>ETH</span>"
                        + "</div>"
                        + "<div class='preview-inner-modal-btn'>"
                        + "<a href='javascript:void(0)' class='theme-button1 w-100' onclick='addListing(\""+ nft.token_address +"\")'>Set Price</a>"
                        + "<button class='theme-button2 w-100'>Cancel</button>"
                        + "</div>"
                        + "</form>"
                        + "</div>"
                        + "</div>"
                        + "</div>"
                        + "</div>"
                        + "</div>"

                        + "<div class='modal fade common-modal purchase-inner-modal' id='purchase1Modal' tabindex='-1' aria-labelledby='purchase1ModalLabel' aria-hidden='true'>"
                        + "<div class='modal-dialog modal-dialog-centered'>"
                        + "<div class='modal-content'>"
                        + "<div class='modal-header p-0'>"
                        + "<h4 class='modal-title' id='purchase1ModalLabel'>Checkout</h4>"
                        + "<button type='button' class='close' data-dismiss='modal' aria-label='Close'>"
                        + "<span aria-hidden='true'>&times;</span>"
                        + "</button>"
                        + "</div>"
                        + "<div class='modal-body p-0'>"
                        + "<div class='change-price-box checkout-content-box'>"
                        + "<p class='preview-inner-modal-info'>You have to pay "+ web3.utils.fromWei(totalSumCharge.toString(), 'ether') +" ETH</p>"
                        + "<table class='table'>"
                        + "<tbody>"
                        + "<tr><td>"+ web3.utils.fromWei(listings.price, 'ether') +"</td><th scope='row'>ETH</th></tr>"
                        + "<tr><td>Your balance</td><th scope='row'>"+ getCookie('_be') +" ETH</th></tr>"
                        + "<tr><td>Service fee</td><th scope='row'>"+ web3.utils.fromWei(listings.fees, 'ether') +" ETH</th></tr>"
                        + "<tr><td>You have to pay</td><th scope='row'>"+ web3.utils.fromWei(totalSumCharge.toString(), 'ether') +" ETH</th></tr>"
                        + "</tbody>"
                        + "</table>"
                        // + "<div class='creator-not-verified d-flex justify-content-center align-items-center'>"
                        // + "<div class='creator-not-verified-left'><i class='fas fa-exclamation'></i></div>"
                        // + "<div class='creator-not-verified-right'>"
                        // + "<p class='font-medium'>This creator is not verified</p>"
                        // + "<p class='font-12'>Purchase this item at your own risk</p>"
                        // + "</div>"
                        // + "</div>"
                        + "<div class='preview-inner-modal-btn'>"
                        + "<button class='theme-button1 w-100' onclick='purchase(\""+ $('#token_address').data('id') +"\", "+ $('#token_id').data('id') +", "+ listings.price +", "+ listings.fees +", \""+ nft.owner_of +"\")'>I understand & continue</button>"
                        + "<button class='theme-button2 w-100' data-dismiss='modal' aria-label='Close'>Cancel</button>"
                        + "</div></div></div></div></div></div>"


                        + "<div class='modal fade common-modal purchase-inner-modal' id='purchase2Modal' data-backdrop='static' data-keyboard='false' tabindex='-1' aria-labelledby='purchase2ModalLabel' aria-hidden='true'>"
                        + "<div class='modal-dialog modal-dialog-centered'>"
                        + "<div class='modal-content'>"
                        + "<div class='modal-header p-0'>"
                        + "<h4 class='modal-title' id='purchase2ModalLabel'>Follow steps</h4>"
                        + "<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>"
                        + "</div>"
                        + "<div class='modal-body p-0'>"
                        + "<div class='change-price-box checkout-content-box'>"
                        + "<div id='depo-txt'></div>"
                        + "<div id='pur-txt'></div>"
                        + "<div class='preview-inner-modal-btn' id='go-my-artworks'> <button class='theme-button2 w-100'>Processing</button> </div>"
                        + "</div></div></div></div></div>"
                    );
                },
                error: function(data) {
                    console.log(data)
                }
            });

        }

        function onSaleModalShow() {
            $('#changePriceModal').modal('show');
        }

        async function addListing(_contractAddress) {
            $('#changePriceModal').modal('hide');
            $('#purchase2Modal').modal('show');
            $('#depo-txt').html(ongoingSnippet('Approve', 'Checking balance and approving'));
            $('#pur-txt').html(pendingSnippet('Listing', 'Set nft to application contract for selling'));
            await setApprovalForAll(_contractAddress)
            $('#depo-txt').html(doneSnippet('Approve', 'Checking balance and approving'));
            $('#pur-txt').html(ongoingSnippet('Listing', 'Set nft to application contract for selling'));
            let price = $('#price').val() * ("1e" + 18);
            let fees_eth = $('#price').val() * (trans_fees / 100);
            let fees = fees_eth * ("1e" + 18);
            let token_id = $('#token_id').val();
            await createMarketItem(_contractAddress, token_id, price, fees);
            $('#depo-txt').html(doneSnippet('Approve', 'Checking balance and approving'));
            $('#pur-txt').html(doneSnippet('Listing', 'Set nft to application contract for selling'));
            $('#go-my-artworks').html("<button class='theme-button1 w-100' onclick='reloadPage()'>Refresh Page</button>");
        }

        async function setApprovalForAll(_contractAddress) {
            let user = Moralis.User.current();
            const contract2 = new web3.eth.Contract(contract_abi, _contractAddress);
            const txtr = await contract2.methods.setApprovalForAll(nft_contract_address, true).send({ from: user.get("ethAddress") });
            console.log('approved')
            console.log(txtr)
            return txtr
            // let options = {
            //     contractAddress: nft_contract_address,
            //     functionName: "setApprovalForAll",
            //     abi: contract_abi,
            //     Params: {
            //         operator: _contractAddress,
            //         approved: true,
            //     },
            // };
            // console.log(options);
        }

        async function createMarketItem(_contractAddress, token_id, price, fees) {
            let user = Moralis.User.current();
            console.log(user.get("ethAddress"));
            let msg_val = 0.002 * ("1e" + 18);
            const txtr = await contract.methods.addListing(price, fees, _contractAddress, token_id).send({ from: user.get("ethAddress") });
            console.log('listed')
            console.log(txtr)
            return txtr
            // let options = {
            //     contractAddress: nft_contract_address,
            //     functionName: "createMarketItem",
            //     abi: contract_abi,
            //     Params: {
            //         nftContractAddress: _contractAddress,
            //         tokenId: token_id,
            //         price: price,
            //     },
            //     msgValue: Moralis.Units.ETH(0.002),
            // };
            // console.log(options);
        }

        function purchaseModal()
        {
            $('#purchase1Modal').modal('show');
        }
        async function purchase(_contractAddress, token_id, price, fees, destAddr)
        {
            let user = Moralis.User.current();


            $('#purchase1Modal').modal('hide');
            $('#purchase2Modal').modal('show');
            $('#depo-txt').html(ongoingSnippet('Deposit', 'Sending transaction to the admin contract'));
            $('#pur-txt').html(pendingSnippet('Purchase', 'Transfer the token'));
            console.log(user.get("ethAddress"));
            console.log(fees);
            let totalPrice = price + fees;
            const txtd = await contract.methods.deposit(_contractAddress, token_id).send({ from: user.get("ethAddress"), value: totalPrice });
            $('#depo-txt').html(doneSnippet('Deposit', 'Sending transaction to the admin contract'));
            $('#pur-txt').html(ongoingSnippet('Purchase', 'Transfer the token'));
            console.log('deposited')
            console.log(txtd)
            const txtr = await contract.methods.purchase(_contractAddress, token_id, price, fees, destAddr, admin_contract_address).send({ from: user.get("ethAddress") });
            console.log('purchased')
            console.log(txtr)
            $('#depo-txt').html(doneSnippet('Deposit', 'Sending transaction to the admin contract'));
            $('#pur-txt').html(doneSnippet('Purchase', 'Transfer the token'));
            $('#go-my-artworks').html("<button class='theme-button1 w-100' onclick='goToMyArtworks()'>Go To My Artworks</button>");

            var datax = {
                'fees' : fees,
                'amount' : price,
                'buyer' : user.get("ethAddress"),
                'seller' : destAddr,
                'admin' : '{{env('ADMIN_ADDRESS')}}',
                'token_address' : _contractAddress,
                'token_id' : token_id,
                '_token' : '{{csrf_token()}}'
            }
            console.log(datax);
            $.ajax({
                type: 'POST',
                enctype : "application/x-www-form-urlencoded",
                url: '{{route('user_product_purchase')}}',
                data: datax,
                dataType: 'JSON',
                success: function(data) {
                    console.log(data)
                },
                error: function(data) {
                    alert('Error!')
                    return 0;
                }
            });
        }

        function fixURL(url) {
            if (url.startsWith("ipfs://ipfs")) {
                return "https://ipfs.moralis.io:2053/ipfs/" + url.split("ipfs://ipfs")[1];
            } else if (url.startsWith("ipfs")) {
                return "https://ipfs.moralis.io:2053/ipfs/" + url.split("ipfs://")[1];
            } else {
                return url + "?format=json";
            }
        }
    </script>
@endsection
