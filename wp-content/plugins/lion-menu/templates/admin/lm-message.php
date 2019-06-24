<style>
    #message {
        top: 32px;
        left: 160px;
    }
    @media (max-width: 960px) {
        #message {
            left: 36px;
        }
    }
    @media (max-width: 785px) {
        #message {
            left: 0px;
        }
    }
</style>

<div id="message" class="bg-white fixed-top pt-3 pl-3 w-100">
    <div class="alert alert-success alert-dismissible fade show w-75" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <div id="message-content">
            Empty.
        </div>
    </div>
</div>
