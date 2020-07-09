<?php
namespace Brikl\Studio\Controller;

/**
 * Inchoo Custom router Controller Router
 *
 * @author      Zoran Salamun <zoran.salamun@inchoo.net>
 */
class Router implements \Magento\Framework\App\RouterInterface
{
    /**
     * @var \Magento\Framework\App\ActionFactory
     */
    protected $actionFactory;

    /**
     * Response
     *
     * @var \Magento\Framework\App\ResponseInterface
     */
    protected $_response;

    /**
     * @param \Magento\Framework\App\ActionFactory $actionFactory
     * @param \Magento\Framework\App\ResponseInterface $response
     */
    public function __construct(
        \Magento\Framework\App\ActionFactory $actionFactory,
        \Magento\Framework\App\ResponseInterface $response
    ) {
        $this->actionFactory = $actionFactory;
        $this->_response = $response;
    }

    /**
     * Validate and Match
     *
     * @param \Magento\Framework\App\RequestInterface $request
     * @return bool
     */
    public function match(\Magento\Framework\App\RequestInterface $request)
    {
        $identifier = trim($request->getPathInfo(), '/');

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();

        $collection = $objectManager->create(\Brikl\Studio\Model\ResourceModel\Settings\Collection::class);

        $threeDOnly = null;

        $collection->addFieldToFilter('key', 'studio_route');
        
        $load = $collection->load();
        $data = $load->getData();

        $route_text = 'custom-design';

        if (count($data) > 0 && trim($data[0]['value']) !== '') {
            $route_text = trim($data[0]['value']);
        }

        if (preg_match('/^(([a-z]{2})\/)*' . $route_text . '$/', $identifier, $matches)) {
            $params = $request->getParams();

            $lang = (isset($matches[2]))? $matches[2] : null;

            if (!$lang) {
                $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
                $store = $objectManager->get('Magento\Framework\Locale\Resolver');

                $lang = substr($store->getLocale(), 0, 2);
            }

            $mp = (isset($params['mp']))? $params['mp'] : null;
            $p = (isset($params['p']))? $params['p'] : null;
            $pd = (isset($params['pd']))? $params['pd'] : null;
            if ($mp) {
                $request->setModuleName('brikl')->setControllerName('CustomDesign')->setActionName('CustomDesign')
                ->setParams([
                    'lang' => $lang,
                    'mp' => $mp,
                    'p' => $p,
                    'pd' => $pd
                ]);
            } else {
                return ;
            }
        } else {
            //There is no match
            return;
        }

        /*
         * We have match and now we will forward action
         */
        return $this->actionFactory->create(
            'Magento\Framework\App\Action\Forward',
            ['request' => $request]
        );
    }
}
