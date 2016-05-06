<?php
namespace {
	/* Enigma
	 *
	 *   Concept) Module-based IRC Bot with limited multithreading
	 *   The idea is to provide a simple-to-use coding interface for developers to expand on.
	 *   Each module has absolute freedom of code and is easily configurable with the bots' event
	 *     triggers. However, due to the single-threaded nature of PHP, the execution of the code
	 *     interrupts the socket listening cycle, which is obviously not ideal for implementation.
	 *
	 *   Working around PHP's base engine limitations to enable multithreading proved to be limited
	 *     due to the lack of a permanent solution for shared resources.
	 *     The unstable nature of such code also makes it highly undesirable.
	 *     Even so, Enigma has implemented a handler to run such modules in a thread of their own,
	 *     the public variable "multithread" must be set to true in the module's main class.
	 *
	 *   It's important to note that due to lack of shared resources, multithreded classes won't be
	 *     able to access objects that are not their own. As a result, instant output is simply not
	 *     possible, given we can't share the stream resource (attempts to access these objects may
	 *     cause a fatal error).
	 *
	 *   As a workaround to not having any access to the stream resource in the module's executed
	 *     thread, the thread's output writes everything into a flatfile buffer instead. During the
	 *     next iteration enigma will output the entire buffer. Make sure to change the value of
	 *     ignorebuffer to false in the configuration file before attempting this, it defaults to
	 *     true in order to remove the unecessary slowdown that this check would cause when running
	 *     without multithreading.
	 *
	 *    Usage) See configuration.php   
	 *    Development)
	 *      Each module must have it's own namespace with all it's code and a main() class.
	 *      You need a method to trigger execution, the following public functions can be declared
	 *        in the main class and will be executed once the bot sees the event happening:
	 *          - onCommand(), onMessage() , onJoin()
	 *          - onPart()   , onKick()    , onQuit(), onNick()
	 *          - onConnect(), onNicklist()
	 */

	#Configuration
	require("configuration.php");

	#Execution
	\Enigma\debug("Welcome.");
	\Enigma\mysql::connect();
	\Enigma\modules::load();
	\Enigma\brain::start();
}
?>