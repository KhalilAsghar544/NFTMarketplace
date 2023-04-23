(function ($) {
    "use strict";

    getNFTs();

    async function getNFTs() {
        let user = Moralis.User.current();
        if (user) {
            const options = { chain: 'rinkeby', address: user.get("ethAddress") };
            const nftCount = await Moralis.Web3.getNFTsCount(options);
            if (nftCount > 0) {
                const allNFTs = await Moralis.Web3API.account.getNFTs(options);
                console.log(allNFTs.result);
                allNFTs.result.forEach( (nft) => {
                    let d_name = nft.name != null ? nft.name : nft.block_number_minted;
                    let nft_name = d_name +":"+ nft.token_id;
                    let nft_image = '/assets/user/img/placeholder.webp';
                    if(nft.metadata != null) {
                        let data = JSON.parse(nft.metadata);
                        nft_name = data.name;
                        nft_image = data.image;
                    }

                    $("#post").html($("#post").html()
                        + "<div class='col-12 col-sm-6 col-md-4 col-lg-4'>"
                        + "<div class='explore-item user-profile-item'>"
                        + "<div class='artist-img position-relative'>"
                        + "<img src='"+ fixURL(nft_image) +"' alt='explore-img' width='250' height='150' class='img-fluid'>"
                        + "<div class='artist-overlay position-absolute'>"
                        + "<div class='price-box-wrap d-flex align-items-center justify-content-between'>"
                        + "<div class='bg-green price-btn'>"+ d_name +"</div>"
                        + "<a href='javascript:void(0)' class='bg-white add-like'><i class='fas fa-heart'></i></a>"
                        + "</div>"
                        + "<a href='/nft-details/"+ nft.token_address +"/"+ nft.token_id +"' class='place-a-bid-btn'>Purchase Now</a>"
                        + "</div>"
                        + "</div>"
                        + "<div class='explore-content'>"
                        + "<a href='/nft-details/"+ nft.token_address +"/"+ nft.token_id +"'><h5 class='font-semi-bold'>"+ nft_name +"</h5></a>"
                        + "<div class='explore-small-box explore-author-wrap d-flex align-items-center justify-content-between'>"
                        + "<div class='explore-author d-flex align-items-center'>"
                        + "<p>Token <span>"+ nft.contract_type +"</span></p>"
                        + "</div>"
                        + "<div class='like-box'>"
                        + "<i class='far fa-heart'></i> 0"
                        + "</div>"
                        + "</div>"
                        + "<div class='explore-small-box d-flex align-items-center justify-content-between'>"
                        + "<p class='on-sell'>Status <span>Minted</span></p>"
                        + "<p class='font-medium top-artist-stock-qty'>"+nft.amount+" in stock </p>"
                        + "</div>"
                        + "</div>"
                        + "</div>"
                        + "</div>");
                // allNFTs.forEach( (nft) => {
                //     fetch(fixURL(nft.token_uri))
                //         .then(response => response.json())
                //         .then(data => {
                //             $("#post").html($("#post").html()
                //                 + "<div class='col-12 col-sm-6 col-md-4 col-lg-4'>"
                //                 + "<div class='explore-item user-profile-item'>"
                //                 + "<div class='artist-img position-relative'>"
                //                 + "<img src='"+ fixURL(data.image) +"' alt='explore-img' width='250' height='150' class='img-fluid'>"
                //                 + "<div class='artist-overlay position-absolute'>"
                //                 + "<div class='price-box-wrap d-flex align-items-center justify-content-between'>"
                //                 + "<div class='bg-green price-btn'>NFT</div>"
                //                 + "<a href='javascript:void(0)' class='bg-white add-like'><i class='fas fa-heart'></i></a>"
                //                 + "</div>"
                //                 + "<a href='/nft-details/"+ nft.token_address +"/"+ nft.token_id +"' class='place-a-bid-btn'>Purchase Now</a>"
                //                 + "</div>"
                //                 + "</div>"
                //                 + "<div class='explore-content'>"
                //                 + "<a href='/nft-details/"+ nft.token_address +"/"+ nft.token_id +"'><h5 class='font-semi-bold'>"+ data.name +"</h5></a>"
                //                 + "<div class='explore-small-box explore-author-wrap d-flex align-items-center justify-content-between'>"
                //                 + "<div class='explore-author d-flex align-items-center'>"
                //                 + "<p>Uploaded <span>22:00:00</span></p>"
                //                 + "</div>"
                //                 + "<div class='like-box'>"
                //                 + "<i class='far fa-heart'></i> 0"
                //                 + "</div>"
                //                 + "</div>"
                //                 + "<div class='explore-small-box d-flex align-items-center justify-content-between'>"
                //                 + "<p class='on-sell'>Status <span>Minted</span></p>"
                //                 + "<p class='font-medium top-artist-stock-qty'>"+nft.amount+" in stock </p>"
                //                 + "</div>"
                //                 + "</div>"
                //                 + "</div>"
                //                 + "</div>");
                //         });
                });
            }
        }
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




    let paginate = 1;
    loadOnSales(paginate);
    // loadMoreData(paginate);
    loadMoreDataCreated(paginate);
    loadMoreDataLike(paginate);
    loadFollowing(paginate);
    loadFollower(paginate);

    $('#load-more-sale').on('click', function() {
        let page = $(this).data('paginate');
        loadOnSales(page);
        $(this).data('paginate', page+1);
    });
    function loadOnSales(paginate) {
        $.ajax({
            url: $('#on-sale-data').val() + '?page=' + paginate,
            type: 'get',
            datatype: 'html',
            beforeSend: function() {
                $('#load-more-sale').text('Loading...');
            }
        })
        .done(function(data) {
            if(data.length == 0 && paginate == 1) {
                $('#load-more-sale').text('No Data Found!');
                return;
            }
            else if(data.length == 0) {
                $('.invisible').removeClass('invisible');
                $('#load-more-sale').hide();
                return;
            } else {
                $('#load-more-sale').text('Load more...');
                $('#post-sale').append(data);
            }
        })
        .fail(function(jqXHR, ajaxOptions, thrownError) {
            alert('Something went wrong.');
        });
    }
    // $('#load-more').on('click', function() {
    //     let page = $(this).data('paginate');
    //     loadMoreData(page);
    //     $(this).data('paginate', page+1);
    // });
    // function loadMoreData(paginate) {
    //     $.ajax({
    //         url: $('#my-collection-data').val() + '?page=' + paginate,
    //         type: 'get',
    //         datatype: 'html',
    //         beforeSend: function() {
    //             $('#load-more').text('Loading...');
    //         }
    //     })
    //         .done(function(data) {
    //             if(data.length == 0 && paginate == 1) {
    //                 $('#load-more').text('No Data Found!');
    //                 return;
    //             }
    //             else if(data.length == 0) {
    //                 $('.invisible').removeClass('invisible');
    //                 $('#load-more').hide();
    //                 return;
    //             } else {
    //                 $('#load-more').text('Load more...');
    //                 $('#post').append(data);
    //             }
    //         })
    //         .fail(function(jqXHR, ajaxOptions, thrownError) {
    //             alert('Something went wrong.');
    //         });
    // }

    $('#load-more-created').on('click', function() {
        let page = $(this).data('paginate');
        loadMoreDataCreated(page);
        $(this).data('paginate', page+1);
    });
    function loadMoreDataCreated(paginate) {
        $.ajax({
            url: $('#my-created-data').val() + '?page=' + paginate,
            type: 'get',
            datatype: 'html',
            beforeSend: function() {
                $('#load-more-created').text('Loading...');
            }
        })
            .done(function(data) {
                if(data.length == 0 && paginate == 1) {
                    $('#load-more-created').text('No Data Found!');
                    return;
                }
                else if(data.length == 0) {
                    $('.invisible').removeClass('invisible');
                    $('#load-more-created').hide();
                    return;
                } else {
                    $('#load-more-created').text('Load more...');
                    $('#post-created').append(data);
                }
            })
            .fail(function(jqXHR, ajaxOptions, thrownError) {
                alert('Something went wrong.');
            });
    }
    $('#load-more-like').on('click', function() {
        let page = $(this).data('paginate');
        loadMoreDataLike(page);
        $(this).data('paginate', page+1);
    });
    function loadMoreDataLike(paginate) {
        $.ajax({
            url: $('#my-like-data').val() + '?page=' + paginate,
            type: 'get',
            datatype: 'html',
            beforeSend: function() {
                $('#load-more').text('Loading...');
            }
        })
            .done(function(data) {
                if(data.length == 0 && paginate == 1) {
                    $('#load-more-like').text('No Data Found!');
                    return;
                }
                else if(data.length == 0) {
                    $('.invisible').removeClass('invisible');
                    $('#load-more-like').hide();
                    return;
                } else {
                    $('#load-more-like').text('Load more...');
                    $('#post-like').append(data);
                }
            })
            .fail(function(jqXHR, ajaxOptions, thrownError) {
                alert('Something went wrong.');
            });
    }
    $('.cover-photo').on('change', function(e) {
        $('#imgsubmit').click();

    });
    $('#imageUpload').on('submit', (function(e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        let formData = new FormData(this);
        $.ajax({
            url: $('#update-cover-photo').val(),
            type: 'post',
            datatype: 'html',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
        })
            .done(function(data) {
                window.location.reload();
            })
            .fail(function(jqXHR, ajaxOptions, thrownError) {
                alert('Something went wrong.');
            });
    }));
    $('#goToServiceCreate').on('click', function() {
        window.location.href = $(this).attr("data-id");
    });
    function loadFollowing(paginate) {
        $.ajax({
            url: $('#following-data').val() + '?page=' + paginate,
            type: 'get',
            datatype: 'html',
            beforeSend: function() {
                $('#load-more-following').text('Loading...');
            }
        })
            .done(function(data) {
                if(data.length == 0 && paginate == 1) {
                    $('#load-more-following').text('No Data Found!');
                    return;
                }
                else if(data.length == 0) {
                    $('.invisible').removeClass('invisible');
                    $('#load-more-following').hide();
                    return;
                } else {
                    $('#load-more-following').text('Load more...');
                    $('#following').append(data);
                }
            })
            .fail(function(jqXHR, ajaxOptions, thrownError) {
                alert('Something went wrong.');
            });
    }
    $('#load-more-following').on('click', function() {
        let page = $(this).data('paginate');
        loadFollowing(page);
        $(this).data('paginate', page+1);
    });

    function loadFollower(paginate) {
        $.ajax({
            url: $('#follower-data').val() + '?page=' + paginate,
            type: 'get',
            datatype: 'html',
            beforeSend: function() {
                $('#load-more-follower').text('Loading...');
            }
        })
            .done(function(data) {
                if(data.length == 0 && paginate == 1) {
                    $('#load-more-follower').text('No Data Found!');
                    return;
                }
                else if(data.length == 0) {
                    $('.invisible').removeClass('invisible');
                    $('#load-more-follower').hide();
                    return;
                } else {
                    $('#load-more-follower').text('Load more...');
                    $('#follower').append(data);
                }
            })
            .fail(function(jqXHR, ajaxOptions, thrownError) {
                alert('Something went wrong.');
            });
    }
    $('#load-more-follower').on('click', function() {
        let page = $(this).data('paginate');
        loadFollower(page);
        $(this).data('paginate', page+1);
    });
})(jQuery)
