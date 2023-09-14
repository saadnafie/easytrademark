$(document).ready(function () {
//  disable Pay Button until the client check on terms & conditions input
    console.log('sasasas')
    function termsBtn() {

        if (document.getElementById('checkTerms').checked) {
            console.log('sasasas')
            document.getElementById("payBtn").style.pointerEvents = 'auto';
            document.getElementById("payBtn").style.background = '#4B57FF';
        } else {
            document.getElementById("payBtn").style.pointerEvents = 'none';
            document.getElementById("payBtn").style.background = '#eee';
        }
    }

})
