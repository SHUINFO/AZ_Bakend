Component({
    properties: {
        // 从外部传入的数据
        item: {
          type: Object,
          default: {}
        },
        // 下标
        index: {
          type:Number,
          default: 0
        },
        patient_id:{
          type: Number,
          default: 0
        }
      },
      methods:{
        // 标题被点击
        onCardClick(){
          console.log('a',this.properties.item);
          this.triggerEvent('onCardClick', this.properties.item);
        },
        // 收藏被点击
        onFavClick(){
          this.triggerEvent('onFavClick', this.properties.item);
        }
      }
})