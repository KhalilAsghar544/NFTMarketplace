(function($) {

    "use strict";

    $("form.ajax").on('submit', function (event) {
        event.preventDefault();
        let enctype = $(this).prop("enctype");
        if (!enctype) {
            enctype = "application/x-www-form-urlencoded";
        }
        $.ajax({
            type: $(this).prop('method'),
            encType: enctype,
            contentType: false,
            processData: false,
            url: $(this).prop('action'),
            data: new FormData( $(this)[0]),
            dataType: 'json',
            success: function(data) {
                showMessage(data);
            },
            error: function(data) {
                showMessage(data);
            }
        });
        return false;
    });

    async function upload(ref){
        $('#mintProcessModal').modal('show');
        $('#ipfs-txt').html(ongoingSnippet('IPFS', 'Uploading to ipfs'));
        $('#mint-txt').html(pendingSnippet('Mint', 'Process for Minting'));
        $('#db-txt').html(pendingSnippet('Upload', 'Data collected to database'));
        const fileInput = document.getElementById("nft-minting-file");
        const data = fileInput.files[0];
        const name = ref.find("#item-name").val()
        const disc = ref.find("#description").val()
        console.log(name);
        if(data == undefined || name == undefined || disc == undefined){
            alert('Data Not Valid');
            return 0;
        }
        const imageFile = new Moralis.File(data.name, data);
         await imageFile.saveIPFS();
        const imageURI = imageFile.ipfs();
        const metadata = {
            "name": name,
            "description": disc,
            "image":imageURI
        }
        const metadataFile = new Moralis.File("metadata.json", {base64 : btoa(JSON.stringify(metadata))});
        await metadataFile.saveIPFS();
        const metadataURI = metadataFile.ipfs();
        console.log(metadataURI);
        $('#ipfs-txt').html(doneSnippet('IPFS', 'Uploading to ipfs'));
        $('#mint-txt').html(ongoingSnippet('Mint', 'Process for Minting'));
        $('#db-txt').html(pendingSnippet('Upload', 'Data collected to database'));
        const txt = await mintToken(metadataURI).then(miniting_finish)
        return imageURI;
    }

    // async function mintToken(tokenURI){
    //     const encodedFunction = web3.eth.abi.encodeFunctionCall({
    //         name: "mint",
    //         type: "function",
    //         inputs: [{
    //             type: 'string',
    //             name: 'tokenURI'
    //         }]
    //     }, [tokenURI]);
    //
    //     const transactionParameters = {
    //         to: nft_contract_address,
    //         from: ethereum.selectedAddress,
    //         data: encodedFunction
    //     };
    //     const txt = await ethereum.request({
    //         method: 'eth_sendTransaction',
    //         params: [transactionParameters]
    //     });
    //     return txt
    // }

    async function mintToken(_uri){
        let user = Moralis.User.current();
        console.log(user.get("ethAddress"));
        const txtr = await contract.methods.mint(_uri).send({ from: user.get("ethAddress") });
        return txtr

        // let options = {
        //     contractAddress: nft_contract_address,
        //     functionName: "mint",
        //     abi: contract_abi,
        //     Params: {
        //         tokenURI: _uri,
        //     },
        // };
        // console.log(options);
    }

    $("form.nft-create-ajax").on('submit', async function (event) {

        event.preventDefault();
        const options = { chain: 'rinkeby', address: nft_contract_address };
        const allTokens = await Moralis.Web3API.token.getAllTokenIds(options);
        let token_id  = allTokens.total;
        console.log(allTokens)
        var image_ipfs = '';
        let enctype = $(this).prop("enctype");
        if (!enctype) {
            enctype = "application/x-www-form-urlencoded";
        }
       if($(this).find('#nft-minting-file').val()!==''){
           image_ipfs = await upload($(this));
       }else{
           alert('Please Select Upload file')
           return 0;
       }
        let formData = new FormData($(this)[0]);
        formData.append('token_address', nft_contract_address);
        formData.append('token_id', token_id);
        formData.append('image_ipfs', image_ipfs);
        $.ajax({
            type: $(this).prop('method'),
            encType: enctype,
            contentType: false,
            processData: false,
            url: $(this).prop('action'),
            data: formData,
            dataType: 'json',
            success: function(data) {
                //showMessage(data);
                // window.location.href = "/user/my-collections";
                $('#ipfs-txt').html(doneSnippet('IPFS', 'Uploading to ipfs'));
                $('#mint-txt').html(doneSnippet('Mint', 'Process for Minting'));
                $('#db-txt').html(doneSnippet('Upload', 'Data collected to database'));
                $('#go-my-artworks').html("<button class='theme-button1 w-100 mt-0' onclick='goToMyArtworks()'>Go To My Artworks</button>");
            },
            error: function(data) {
                //showMessage(data);
            }
        });

    });
    function miniting_finish(_txt){
        console.log(_txt)
        $('#ipfs-txt').html(doneSnippet('IPFS', 'Uploading to ipfs'));
        $('#mint-txt').html(doneSnippet('Mint', 'Process for Minting'));
        $('#db-txt').html(ongoingSnippet('Upload', 'Data collected to database'));
        return false;
    }

    $("form.ajax-withdrawal").on('submit', function (event) {
        event.preventDefault();
        let enctype = $(this).prop("enctype");
        if (!enctype) {
            enctype = "application/x-www-form-urlencoded";
        }
        $.ajax({
            type: $(this).prop('method'),
            encType: enctype,
            contentType: false,
            processData: false,
            url: $(this).prop('action'),
            data: new FormData( $(this)[0]),
            dataType: 'json',
            success: function(data) {
                withdrawalCallback(data);
            },
            error: function(data) {
                withdrawalCallback(data);
            }
        });
        return false;
    });
    $('.number').on('keypress', function(e) {
        if (e.which == 32)
            return false;
    });
    $(document).on('click', '.delete', function () {
        return confirm("Are You Sure To Delete This!");
    });
    $(document).on('click', '.confirm-cover-photo', function () {
        return confirm("Cover photo size will be 1600pz * 330px! Will you confirm it?");
    });
    function alertAjaxMessage(type, message) {
        let addClass = '';
        if (type === 'success') {
            addClass = 'alert-success';
        } else if (type === 'error') {
            addClass = 'alert-danger';
        } else if (type === 'warning') {
            addClass = 'alert-warning';
        } else {
            return false;
        }
        let html = '<div class="alert alert-dismissible fade show alert-float alert-body '+addClass+'">'+
            '<button type="button" class="close ajaxclose" id="" data-dismiss="alert" aria-label="Close">&times;</button>'+
            '<ul class="list-unstyled">'+
            message+
            '</ul>'+
            '</div>';
        $('.ajax-alert').prepend(html);
        $(".ajax-alert .alert-body").fadeTo(4000, 200).hide(200, function () {
            $('.ajax-alert .alert-body').remove()
        });
    }
    function getValidationError(errors) {
        let output = '';
        $.each(errors, function (index, items) {
            $.each(items, function (key, item) {
                output = output + '<li>' + item + '</li>';
            });
        });
        return output;
    }
    function visual_number_format(value)
    {
        value = parseFloat(value);
        if(isNaN(value)){
            value = 0;
        }
        if (Number.isInteger(value)) {
            return value.toFixed(2);
        }
        let temp = value.toFixed(8);
        let number = temp.split('.');
        let floatValue = number[1];
        floatValue = floatValue.toString();
        let result = floatValue.trimRight('0');
        if (result.length < 2) {
            return value.toFixed(2);
        }
        return number[0] + "." + result;
    }
    function showMessage(data) {
        let output = '';
        let type = 'error';
        if (data['status'] == true) {
            output = output + "<li>" + data['message'] + "</li>";
            type = 'success';
        } else if (data['status'] == false) {
            output = output + "<li>" + data['message'] + "</li>";
        } else if (data['status'] === 422) {
            let errors = data['responseJSON']['errors'];
            output = getValidationError(errors);
        }
        else if(data['data']['redirect'] == true) {
            type = 'success';
            output = output + "<li>" + data['message'] + "</li>"
            window.location.href = data['data']['returnRoute'];
        }
        else if (typeof data['responseJSON']['error'] !== 'undefined') {
            output = '<li>' + data['responseJSON']['error'] + '</li>';
        } else {
            output = '<li>' + data['responseJSON']['message'] + '</li>';
        }
        alertAjaxMessage(type, output);
    }

    function withdrawalCallback(response){
        console.log(response);
        var errors = '';
        if (response['status'] === 422) {
            errors = response['responseJSON']['message'];
        }else if (response['status'] === false) {
            errors = response['message'];
        }else if (response['status'] === true) {
            errors = response['message'];
            $('#withdrawalModal').modal('hide');
            $('#withdrawalConfirmModal').modal('show');
            $('#withdrawalConfirmModal').modal({backdrop: 'static', keyboard: false})
            var html = '<div class="alert alert-dismissible fade show alert-float wc-alert-body alert-success">'+
                '<button type="button" class="close ajaxclose" id="" data-dismiss="alert" aria-label="Close">&times;</button>'+
                '<ul class="list-unstyled">'+
                errors+
                '</ul>'+
                '</div>';
            $('.wc-ajax-alert').prepend(html);
            $(".wc-ajax-alert .wc-alert-body").fadeTo(4000, 200).hide(200, function () {
                $('.wc-ajax-alert .wc-alert-body').remove()
            });
            $('.withdrawal-confirm-header').text('Withdrawal amount '+$('.w-amount').val())
            $('#w-hash').val(response['data'])
        }
        var html = '<div class="alert alert-dismissible fade show alert-float w-alert-body alert-danger">'+
            '<button type="button" class="close ajaxclose" id="" data-dismiss="alert" aria-label="Close">&times;</button>'+
            '<ul class="list-unstyled">'+
            errors+
            '</ul>'+
            '</div>';
        $('.w-ajax-alert').prepend(html);
        $(".w-ajax-alert .w-alert-body").fadeTo(4000, 200).hide(200, function () {
            $('.w-ajax-alert .w-alert-body').remove()
        });
    }

    $('#search-service').on('keyup', function() {
        if($(this).val().length == 0) {
            $('#search-work').addClass('d-none');
        }
        else if($(this).val().length <= 3) {
            $('#search-work').removeClass('d-none');
            $('#search-result').html('<li class="media menu-search-result-item"><div class="media-body"><h6 class="mt-0 mb-1 font-13">Loading...</h6></div></li>\n');
        }
        else {
            $('#search-work').removeClass('d-none');
            serachAjax($(this).val());
        }

    });

    function serachAjax(keyword)
    {
        $.ajax({
            url: $('#search-url').val()+'?keyword='+ keyword,
            type: 'get',
            datatype: 'html',
            beforeSend: function() {
                $('#load-more-sale').text('Loading...');
            }
        })
            .done(function(data) {
                $('#search-result').html(data);
            })
            .fail(function(jqXHR, ajaxOptions, thrownError) {
                alert('Something went wrong.');
            });
    }

    $('#login-first').on('click', function () {
        $('#notAuthModal').modal('hide');
    })

})(jQuery);
