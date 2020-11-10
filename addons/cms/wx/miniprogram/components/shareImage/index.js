Component({
  methods: {
    // 生成图片
    onCreate: function(photoUrl, name, job){
      // 下载所需图片 头像
      return this.downLoadImages(photoUrl).then((photoObj) => {
        const ctx = wx.createCanvasContext('share-image', this);
        const canvasWidth = 450;
        const canvasHeight = 370;

          ctx.setFillStyle('#ffffff');
          ctx.fillRect(0,0, canvasWidth,canvasHeight);

          // 渐变背景
          const grd = ctx.createLinearGradient(0, 0, 450, 268);
          grd.addColorStop(0,'#12B2B3');
          grd.addColorStop(1,'#56E0E0');

          ctx.setFillStyle(grd);
          ctx.fillRect(0, 0, 450, 268);

          // 画头像
          if(photoObj){
            if(photoObj.width > photoObj.height){
              ctx.drawImage(photoObj.path, 0, 0, photoObj.width/(photoObj.width/photoObj.height), photoObj.height,34,24,110,110);
            } else {
              ctx.drawImage(photoObj.path, 0, 0, photoObj.width, photoObj.height/(photoObj.height/photoObj.width),34,24,110,110);
            }
          }

          // 写名字
          this.drawText(ctx, name + ' 医生', "#ffffff",40, 160, 56, 'left');
          this.drawText(ctx, job, "#000000",28, 160, 96, 'left');

          // 画分割线
          ctx.beginPath();
          ctx.setLineCap('round');
          ctx.setStrokeStyle('#98E2E3');
          ctx.moveTo(34,150);
          ctx.lineTo(416, 150);
          ctx.stroke();

          // 下面列表文字
          const list = ['用药打卡','治疗科普', '问医生', '用药推荐'];
          for(let i=0;i<2;i++){
            for(let j=0;j<2;j++){
              ctx.beginPath();
              ctx.arc((j * 170)+40,( i* 50)+ 180,2, 0 ,2* Math.PI);
              ctx.setFillStyle('#ffffff');
              ctx.fill();
              this.drawText(ctx, list[i*2 + j], "#ffffff",  28, (j* 170) + 50, (i*50)+190, 'left');
            }
          }

          // 底部按钮背景
          const grd2 = ctx.createLinearGradient(280, 300, 450, 370);
          grd2.addColorStop(0,'#12B2B3');
          grd2.addColorStop(1,'#56E0E0');
          ctx.setFillStyle(grd2);
          ctx.beginPath();
          let startX = 325;
          let startY = 280;
          ctx.moveTo(startX,startY);
          ctx.lineTo(startX + 90, startY);
          ctx.arcTo(startX + 90 + 35, startY, startX + 90 + 35, startY + 35, 35);
          ctx.arcTo( startX + 90 + 35, startY +70, startX + 90, startY + 70, 35);
          ctx.lineTo(startX, startY + 70);
          ctx.arcTo( startX -35, startY + 70, startX - 35, startY + 35, 35);
          ctx.arcTo( startX -35, startY, startX , startY, 35);
          ctx.fill();
          
          // 底部文字
          this.drawText(ctx, '添加医生保持联系', "#000000", 28, 34, 324, 'left');
          this.drawText(ctx, '去添加', "#ffffff", 28, 328, 324, 'left');
  
          return new Promise((res, rej)=>{
            ctx.draw(false,()=>{
              wx.canvasToTempFilePath({
                x:0,
                y:0,
                width: canvasWidth,
                height: canvasHeight,
                canvasId: "share-image",
                success(obj){
                  res(obj.tempFilePath);
                },
                fail(){
                  rej(new Error('生成图片路径失败'));
                },
              }, this);
            });
          });
      });
    },

    // 工具 - 画文字
    drawText(ctx, str, color, fontSize, x, y, textAlign){
      // ctx.setTextBaseline('middle')
      ctx.setTextAlign(textAlign)
      ctx.setFillStyle(color)
      ctx.setFontSize(fontSize)
      ctx.fillText(str, x, y);
    },

    // 工具 - 网络图片需要先下载到本地
    downLoadImages(url){
      return new Promise((res, rej)=>{
        wx.getImageInfo({
          src: url,
          success: (msg)=>{
            res(msg);
          },
          fail: (e) => {
            res(null);
          }
        });
      })
    },
  },
})
