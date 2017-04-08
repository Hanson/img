@extends('layouts.app')

@section('content')
    <div class="container" id="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="jumbotron" id="dropbox" style="border:2px dashed silver;">
                    <h3>拖拽图片到这里上传</h3>
                    <p style="font-size: 16px">或者</p>
                    <p><a href="javascript:;" class="btn btn-primary btn-sm" v-on:click="selectFile">选择文件</a></p>
                    <form id="form" style="visibility: hidden" v-on:change="changeFile"><input type="file" name="file">
                    </form>
                </div>
                <form class="form-inline">
                    <div v-show="url" class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon">url</div>
                            <input id="url" type="text" class="form-control" v-model="text" placeholder="上传成功后的链接"
                                   style="width: 400px;">
                            <div class="input-group-addon">
                                <img class="clip" width="13" data-clipboard-target="#url" src="images/clippy.svg"
                                     alt="Copy to clipboard">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <a v-show="url" href="javascript:;" class="btn btn-default clip"
                           :data-clipboard-text="'![](' + url + ')'">复制 markdown</a>
                    </div>
                    <a v-show="url" class="btn btn-default" target="_blank" :href="url">新窗口打开</a>
                </form>
                <div id="preview"><img :src="url" v-show="url" style="max-width: 750px;"></div>
            </div>
        </div>
    </div>
@endsection

<script src="http://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
<script src="http://cdn.bootcss.com/vue/2.2.6/vue.min.js"></script>
<script src="http://cdn.bootcss.com/axios/0.16.0/axios.min.js"></script>
<script src="http://cdn.bootcss.com/clipboard.js/1.6.1/clipboard.min.js"></script>
@section('js')
    <script>
        $(function () {
            $(document).on({
                dragleave: function (e) {    //拖离
                    e.preventDefault();
                },
                drop: function (e) {  //拖后放
                    e.preventDefault();
                },
                dragenter: function (e) {    //拖进
                    e.preventDefault();
                },
                dragover: function (e) {    //拖来拖去
                    e.preventDefault();
                }
            });

            var dropbox = document.getElementById('dropbox');

            dropbox.addEventListener("drop", function (e) {
                e.preventDefault(); //取消默认浏览器拖拽效果
                dropbox.style.backgroundColor = '#eee';
                var fileList = e.dataTransfer.files;
                //检测是否是拖拽文件到页面的操作
                if (fileList.length == 0) {
                    return false;
                }
                //检测文件是不是图片
                if(fileList[0].type.indexOf('image') === -1){
                    alert("您拖的不是图片！");
                    return false;
                }

                //拖拉图片到浏览器，可以实现预览功能
                var filesize = Math.floor((fileList[0].size) / 1024);
                if(filesize>2048){
                    alert("上传大小不能超过2M.");
                    return false;
                }
                vm.form = new FormData();
                vm.form.append('file', fileList[0]);
                console.log(form);
                vm.upload();
            }, false);
            dropbox.addEventListener("dragover", function (e) {
                dropbox.style.borderColor = 'gray';
                dropbox.style.backgroundColor = 'white';
            }, false);
            dropbox.addEventListener("dragenter", function (e) {
                dropbox.style.borderColor = 'gray';
                dropbox.style.backgroundColor = 'white';
            }, false);
            dropbox.addEventListener("dragleave", function (e) {
                dropbox.style.borderColor = 'silver';
                dropbox.style.backgroundColor = '#eee';
            }, false);
        });


        var vm = new Vue({
            el: '#container',
            data: {
                form: null,
                url: null,
                text: null
            },
            methods: {
                selectFile: function () {
                    $("input[type=file]").click();
                },
                changeFile: function () {
                    var form = document.getElementById('form');
                    this.form = new FormData(form);
                    if ($("input[type=file]").val()) {
                        this.upload();
                    }
                },
                upload: function () {
                    $("#form").submit();
                },
            },
            mounted: function () {
                new Clipboard('.clip');
                $('#form').submit(function (e) {
                    vm.text = '上传中...';
                    vm.url = null;
                    axios.post('/api/upload', vm.form).then(function (response) {
                        var data = response.data;
                        if (data.code === 200) {
                            vm.text = vm.url = data.data;
                        } else {
                            alert(data.data);
                        }
                    }).catch(function (error) {
                        alert(error);
                    });
                    e.preventDefault();
                })
            }
        })
    </script>

@endsection
