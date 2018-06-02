## 首页获取文章列表

### url
`/class/list`

### 请求方法
`GET`

### 请求参数
| 参数名 | 参数类型 | 说明 | 是否必须 |
| :-----: | :-----: | :-----: | :-----: |
| page | int | 分页页数，默认为1 | false |


### 响应参数
| 参数名 | 参数类型 | 说明 |
| :-----: | :-----: | :-----: |
| [].id | int | 课程ID |
| [].sold | int | 卖出数量 |
| [].price | float | 售价 |
| [].img_url | string | 图片地址 |
| [].title | string | 课程标题 |
| current_page | int | 当前页数 |
| total_page | string | 总页数 |

## 问题详情课程特色页

### url
`/class/info`

### 请求方法
`GET`

### 请求参数
| 参数名 | 参数类型 | 说明 | 是否必须 |
| :-----: | :-----: | :-----: | :-----: |
| class_id | int | 问题ID | true |


### 响应参数
| 参数名 | 参数类型 | 说明 |
| :-----: | :-----: | :-----: |
| id | int | 课程ID |
| sold | int | 卖出数量 |
| img_url | string | 图片地址 |
| price | float | 价格 |
| title | string | 标题 |
| status | int | 状态1-可用 0-不可用 |
| introduce[].img_url | string | 介绍图片地址 |
| introduce[].title | string | 介绍标题 |
| introduce[].content | string | 介绍内容 |
| introduce[].sort | int | 排序，大的在前 |

## 问题试听列表

### url
`/class/try`

### 请求方法
`GET`

### 请求参数
| 参数名 | 参数类型 | 说明 | 是否必须 |
| :-----: | :-----: | :-----: | :-----: |
| class_id | int | 问题ID | true |


### 响应参数
| 参数名 | 参数类型 | 说明 |
| :-----: | :-----: | :-----: |
| [].id | int | 课程ID |
| [].resource_type | int | 资源类型，0-视频 1-文章 |
| [].sort | int | 试听列表排序 大的在前 |
| [].resource.id | int | 资源ID |
| [].resource.media_url | string | 视频地址， resource_type=0时存在 |
| [].resource.media_time | int | 视频长度， resource_type=0时存在 |
| [].resource.size | int | 视频大小，单位：byte， resource_type=0时存在 |
| [].resource.title | string | 文章标题，resource_type=1时存在 |
| [].resource.img_url | string | 文章图片地址，resource_type=1时存在 |
| [].resource.content | string | 文章内容，resource_type=1时存在 |

## 问题章节

### url
`/class/chapter`

### 请求方法
`GET`

### 请求参数
| 参数名 | 参数类型 | 说明 | 是否必须 |
| :-----: | :-----: | :-----: | :-----: |
| class_id | int | 问题ID | true |


### 响应参数
| 参数名 | 参数类型 | 说明 |
| :-----: | :-----: | :-----: |
| [].id | int | 章节ID |
| [].title | string | 章节标题 |
| [].chapter_id | int | 第几章 |
| lesson.[].id | int | 课时ID |
| lesson.[].lesson_no | int | 第几课 |
| lesson.[].desc | string | 课程描述 |
| lesson.[].resource_type | int | 资源类型，0-视频 1-文章 |
| lesson.[].resource.id | int | 资源ID |
| lesson.[].resource.media_url | string | 视频地址， resource_type=0时存在 |
| lesson.[].resource.media_time | int | 视频长度，单位：秒， resource_type=0时存在 |
| lesson.[].resource.size | int | 视频大小，单位：byte， resource_type=0时存在 |
| lesson.[].resource.title | string | 文章标题，resource_type=1时存在 |
| lesson.[].resource.img_url | string | 文章图片地址，resource_type=1时存在 |
| lesson.[].resource.content | string | 文章内容，resource_type=1时存在 |

