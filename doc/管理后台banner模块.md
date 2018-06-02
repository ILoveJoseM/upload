## 后台获取banner

### url
`/admin/banner/list`

### 请求方法
`GET`

### 请求参数
| 参数名 | 参数类型 | 说明 | 是否必须 |
| :-----: | :-----: | :-----: | :-----: |

### 响应参数
| 参数名 | 参数类型 | 说明 |
| :-----: | :-----: | :-----: |
| [].id | int | bannerID |
| [].img_url | string | 图片url |
| [].url | string | 跳转链接 |
| [].sort | int | 排序 |

## 后台banner详情

### url
`/admin/banner/get`

### 请求方法
`GET`

### 请求参数
| 参数名 | 参数类型 | 说明 | 是否必须 |
| :-----: | :-----: | :-----: | :-----: |
| banner_id | int | bannerID | true |


### 响应参数
| 参数名 | 参数类型 | 说明 |
| :-----: | :-----: | :-----: |
| id | int | 课程ID |
| sold | int | 卖出数量 |
| img_url | string | 图片地址 |
| price | float | 价格 |
| title | string | 标题 |
| status | int | 状态1-可用 0-不可用 |

## 新增banner

### url
`/admin/banner/add`

### 请求方法
`POST`

### 请求参数
| 参数名 | 参数类型 | 说明 | 是否必须 |
| :-----: | :-----: | :-----: | :-----: |
| img_url | string | 图片地址 | true |
| url | string | 跳转地址 | false |
| status | int | 状态0-冻结 1-可用，默认为1 | false |
| sort | int | 状态0-冻结 1-可用，默认为1 | false |


### 响应参数
| 参数名 | 参数类型 | 说明 |
| :-----: | :-----: | :-----: |
## 更新banner

### url
`/admin/banner/update`

### 请求方法
`POST`

### 请求参数
| 参数名 | 参数类型 | 说明 | 是否必须 |
| :-----: | :-----: | :-----: | :-----: |
| banner_id | int | banner的ID | true |
| img_url | string | 图片地址 | true |
| url | string | 跳转地址 | false |
| status | int | 状态0-冻结 1-可用，默认为1 | false |
| sort | int | 排序小的在前 | false |


### 响应参数
| 参数名 | 参数类型 | 说明 |
| :-----: | :-----: | :-----: |
## 冻结banner

### url
`/admin/banner/delete`

### 请求方法
`POST`

### 请求参数
| 参数名 | 参数类型 | 说明 | 是否必须 |
| :-----: | :-----: | :-----: | :-----: |
| banner_id | int | banner的ID | true |


### 响应参数
| 参数名 | 参数类型 | 说明 |
| :-----: | :-----: | :-----: |
