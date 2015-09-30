function BorderSlidingPanel(div, position, offset){
    this.div = div;
    this.position = position;
    this.animationBusy = false;
    this.width = div.outerWidth() + offset;
}

BorderSlidingPanel.prototype.close = function(onCompleteDo){
    this.animationBusy = true;
    var that = this;
    if(this.position == "right"){
        TweenLite.to(that.div, 1, {
            right: "-" + that.width +"px",
            ease:Power1.easeOut,
            onComplete: function () {
                that.animationBusy = false;
                onCompleteDo();
            }
        });
    }else{
        TweenLite.to(that.div, 1, {
            left: "-" + that.width +"px",
            ease:Power1.easeOut,
            onComplete: function () {
                that.animationBusy = false;
                onCompleteDo();
            }
        });
    }
};
BorderSlidingPanel.prototype.open = function(onCompleteDo){
    this.animationBusy = true;
    var that = this;
    if(that.position == "right"){
        TweenLite.to(that.div, 1, {
            right: "0px",
            ease:Power1.easeOut,
            onComplete: function () {
                that.animationBusy = false;
                onCompleteDo();
            }
        });
    }else{
        TweenLite.to(that.div, 1, {
            left: "0px",
            ease:Power1.easeOut,
            onComplete: function () {
                that.animationBusy = false;
                onCompleteDo();
            }
        });
    }
};
